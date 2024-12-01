<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request): RedirectResponse {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name'=> 'required|string',
            'email'=> 'required|string|email',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

         $user->name = $request->input('name');
         $user->email = $request->input('email');
        if($request->hasFile('avatar')) {
            if($user->avatar) {
                Storage::delete('public/' . ($user->avatar));
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();
        return redirect()->route('dashboard')->with('success', 'Profile updated successfully');
    }
}
