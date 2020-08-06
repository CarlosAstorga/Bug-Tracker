<?php

namespace App\Http\Controllers;

use App\Category;
use App\Priority;
use App\Project;
use App\Status;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tickets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.form')->with([
            'ticket'    => new Ticket(),
            'catalogs'  => $this->getCatalogs()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Ticket::create($this->validateRequestInputs($request));
        return redirect('tickets');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        Gate::authorize('is-author', $ticket);

        $canDelete = false;
        if (Gate::allows('assign-users')) $canDelete = true;
        return view('tickets.ticket')->with(['ticket' => $ticket, 'role' => $canDelete]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        Gate::authorize('is-author', $ticket);

        return view('tickets.form')->with([
            'ticket'    => $ticket,
            'catalogs'  => $this->getCatalogs()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update($this->validateRequestInputs($request));
        return redirect('tickets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        if ($ticket->files()->count()) {
            $path = public_path('uploads');
            foreach ($ticket->files()->get() as $file) {
                unlink($path . '\\' . $file->file);
            }
        }

        $ticket->files()->delete();
        $ticket->comments()->delete();
        $ticket->delete();
    }

    public function list(Request $request)
    {
        $filter = $request->input('filter') ?? null;

        $tickets = Ticket::query();
        if (Gate::denies('assign-users')) {
            $tickets = Ticket::where('developer_id', Auth::user()->id)
                ->orWhere('submitter_id', Auth::user()->id);
        }
        $tickets = $filter ?
            $tickets->where(function ($query) use ($filter) {
                $query->where('title', 'LIKE', '%' . $filter . '%')
                    ->orWhere('created_at', 'LIKE', '%' . $filter . '%')
                    ->orWhereHas('priority', function ($relation) use ($filter) {
                        $relation->where('title', 'LIKE', '%' . $filter . '%');
                    })->orWhereHas('status', function ($relation) use ($filter) {
                        $relation->where('title', 'LIKE', '%' . $filter . '%');
                    })->orWhereHas('category', function ($relation) use ($filter) {
                        $relation->where('title', 'LIKE', '%' . $filter . '%');
                    })->orWhereHas('project', function ($relation) use ($filter) {
                        $relation->where('title', 'LIKE', '%' . $filter . '%');
                    })->orWhereHas('developer', function ($relation) use ($filter) {
                        $relation->where('title', 'LIKE', '%' . $filter . '%');
                    });
            }) : $tickets;

        $tickets = $tickets->orderBy('id', 'DESC');
        $paginator = $tickets->simplePaginate(10)->toJson();

        return $paginator;
    }

    public function getCatalogs()
    {
        return [
            'category'  => Category::get(),
            'priority'  => Priority::get(),
            'status'    => Status::get(),
            'project'   => Project::whereHas('users')->get()
        ];
    }

    public function validateRequestInputs($request)
    {
        $rules = [
            'title'          => 'required|max:50',
            'description'    => 'required|max:100',
            'category_id'    => 'required|exists:App\Category,id',
        ];

        if (Gate::allows('change-status')) {
            $rules['status_id']     = 'required|exists:App\Status,id';
        }

        if (Gate::allows('assign-users')) {
            $rules['status_id']     = 'required|exists:App\Status,id';
            $rules['project_id']    = 'required|exists:App\Project,id';
            $rules['developer_id']  = 'required|exists:App\User,id';
            $rules['priority_id']   = 'required|exists:App\Priority,id';
        }

        $validatedData = $request->validate($rules);
        $validatedData['submitter_id'] = $request->user()->id;
        return $validatedData;
    }
}
