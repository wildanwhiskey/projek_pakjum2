<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user()->load('profile');

        return view('components.profile', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->update($request->only('name', 'email'));
        $user->profile->update($request->only('umur', 'alamat', 'bio'));

        return redirect()->route('profile.edit')->with('success', 'Profile berhasil diperbarui');
    }
}