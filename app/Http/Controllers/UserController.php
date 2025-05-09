<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->with('department')->paginate(5);

        return view('users.index',[
            'users' => $users]);
    }

    public function create()
    {
        $departments = Department::all();
        return view('users.create', [
            'departments' => $departments
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'department_id' => 'required'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'department_id' => $request->department_id,
        ]);

        return redirect('/users')->with('status', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        return view('users.edit', [
            'user' => $user,
            'departments' => $departments
        ]);
    }

    public function update(Request $request, User $user)
    {

    }

    public function destroy(User $user)
    {

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Deleted successfully');
    }
}
