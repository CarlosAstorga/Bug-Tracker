<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.profile');
    }

    public function edit()
    {
        return view('profile.form');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'avatar'    => 'nullable|max:2048|mimes:jpeg,png,jpg',
            'name'      => 'nullable|string|max:50'
        ]);

        if (isset($request->all()['avatar'])) {
            $oldAvatar = $user->avatar;

            if ($oldAvatar != 'avatar.png') unlink(public_path('images/' . $oldAvatar));
            $imageName = time() . '.' . $request->avatar->extension();
            $user->avatar = $imageName;
            $request->avatar->move(public_path('images'), $imageName);
        }

        if (isset($request->all()['name'])) {
            $user->name = $request->input()['name'];
        }

        if ($user->isDirty()) {
            $user->save();
            return redirect()->route('profile')->with('success', 'Datos actualizados');
        }

        return redirect()->route('profile');
    }
}
