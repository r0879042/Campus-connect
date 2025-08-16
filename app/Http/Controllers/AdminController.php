<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin', compact('admins'));
    } 

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);

        // Prevent self-deletion
        $currentUser = Auth::user();

        // Prevent self-deletion
        if ($currentUser && $currentUser->id === $user->id) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return back()->with('success', 'Administrator removed successfully.');
    }
}
