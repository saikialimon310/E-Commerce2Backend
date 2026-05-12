<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ✅ USER LIST
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    // ✅ UPDATE ROLE
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', 'Role updated successfully');
    }

    // ✅ UPDATE STATUS
    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status updated successfully');
    }
}