<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'dob' => 'required|date',
            'password' => 'nullable|min:8',
        ]);

        // $user->update($request->only(['email', 'phone_number', 'dob']));

        $user->dob = $request->dob;
        $user->phone_number = $request->phone_number;
        $request->password ? $user->password = Hash::make($request->password) : '';
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}
