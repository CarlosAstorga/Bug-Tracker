<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.form')->with(['project' => new Project()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'         => 'required|max:50',
            'description'   => 'required|max:100',
        ]);

        $project = Project::create($validatedData);
        $project->users()->sync($request->users);

        return redirect('projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.project')->with(['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        return view('projects.form')->with(['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'title'         => 'required|max:50',
            'description'   => 'required|max:100',
        ]);

        $project->users()->sync($request->users);
        $project->update($validatedData);

        return redirect('projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->tickets()->update(['project_id' => null]);
        $project->users()->detach();
        $project->delete();
    }

    public function list(Request $request)
    {
        $filter = $request->input('filter') ?? null;

        $projects = Project::query();
        $projects = $filter ?
            $projects->where(function ($query) use ($filter) {
                $query->where('title', 'LIKE', '%' . $filter . '%')
                    ->orWhere('description', 'LIKE', '%' . $filter . '%');
            }) : $projects;
        $projects = $projects->orderBy('id', 'DESC');
        $paginator = $projects->simplePaginate(10)->toJson();

        return $paginator;
    }

    public function getTickets(Request $request, Project $project)
    {
        $tickets = $project->tickets();
        $filter = $request->input('filter') ?? null;

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
        $paginator = $tickets->simplePaginate(5)->toJson();
        return $paginator;
    }

    public function getUsers(Request $request, Project $project)
    {
        $filter = $request->input('filter') ?? null;

        $users = $project->users();
        $users = $filter ?
            $project->users()->where(function ($query) use ($filter) {
                $query->where('name', 'LIKE', '%' . $filter . '%')
                    ->orWhere('email', 'LIKE', '%' . $filter . '%')
                    ->orWhereHas('roles', function ($relation) use ($filter) {
                        $relation->where('title', 'LIKE', '%' . $filter . '%');
                    });
            }) : $users;
        $users = $users->orderBy('id', 'DESC');
        $paginator = $users->simplePaginate(5)->toJson();

        return $paginator;
    }
}
