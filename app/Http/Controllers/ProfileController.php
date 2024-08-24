<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // Get the authenticated user

        return view('profile.edit', compact('user')); // Pass the user data to the view
    }

    public function update(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // Add other fields as necessary
        ]);

        // Update the user's profile
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // Update other fields as necessary

        $user->save(); // Save the changes

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
