<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\HTTP\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register (): View {
        return view('auth.register');
    }
    public function store (Request $request): RedirectResponse {
      $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email'=> 'required|string|email|max:100|unique:users',
        'password'=>'required|string|min:8|confirmed']);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        return redirect()->route('login')->with('success', 'You are registered successfully');
    }
}
