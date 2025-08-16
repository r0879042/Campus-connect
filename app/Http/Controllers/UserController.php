<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    // Show all regular users
    public function index()
    {
        $users = User::where('role', 'user')->get(); 
        return view('users', ['users' => $users]);
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // prevent deleting admins by mistake
        if ($user->role !== 'admin') {
            $user->delete();
        }

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }
}
