<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('department')
        ->withCount('tasks')
        ->latest()
        ->paginate(10);

        return view('users.index', [
            'users' => $users
        ]);
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function create(){$departments = Department::all();
        return view('users.create', [
            'departments' => $departments    ]);}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'department_id' => $validated['department_id']
        ]);

        return redirect()->route('users.index');
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
            'department_id' => 'required|exists:departments,id'
        ]);

        $user = User::findOrFail($validated['user_id']);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'department_id' => $validated['department_id']
        ]);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function show($id)
    {
        $user = User::withCount('tasks')->findOrFail($id);
        return view('users.show', compact('user'));
    }


}
