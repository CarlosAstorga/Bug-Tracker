<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.form')->with([
            'user'  => $user,
            'roles' => Role::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
    }

    public function list(Request $request)
    {
        $filter = $request->input('filter') ?? null;

        $users = User::query();
        $users = $filter ?
            $users->where(function ($query) use ($filter) {
                $query->where('name', 'LIKE', '%' . $filter . '%')
                    ->orWhere('email', 'LIKE', '%' . $filter . '%')
                    ->orWhereHas('roles', function ($relation) use ($filter) {
                        $relation->where('title', 'LIKE', '%' . $filter . '%');
                    });
            }) : $users;

        $users = $users->orderBy('id', 'DESC');
        $paginator = $users->simplePaginate(10)->toJson();

        return $paginator;
    }
}
