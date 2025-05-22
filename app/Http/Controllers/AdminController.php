<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Show admin dashboard
    public function index()
    {
        return view('admin.dashboard');
    }

    // List all users
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // Activate a user
    public function activate($userId)
    {
        $user = User::findOrFail($userId);
        $user->active = true;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User activated.');
    }

    // Deactivate a user
    public function deactivate($userId)
    {
        $user = User::findOrFail($userId);
        $user->active = false;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User deactivated.');
    }

    // Delete a user
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted.');
    }

    // List To-Do tasks for a specific user
    public function userTodos($userId)
    {
        $user = User::findOrFail($userId);
        $todos = Todo::where('user_id', $userId)->get();

        return view('admin.user_todos', compact('user', 'todos'));
    }
}