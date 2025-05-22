<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreatedMail;
use App\Mail\WelcomeEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->with('department')->paginate(10);
        $users = User::withCount('tasks')->paginate(20);

        return view('users.index',compact('users'));

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

        $plainPassword = $request->password;


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'department_id' => $request->department_id,
        ]);

        $userCount = User::count();

        Mail::to('admin@gmail.com')->send(new WelcomeEmail($user, $userCount));
        Mail::to($user->email)->send(new AccountCreatedMail($user, $plainPassword));

        return redirect('/users')->with(['status' => 'User created successfully.',
        'userCount' => $userCount
    ]);

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => ['nullable','confirmed','min:8','max:20'],

        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' =>$request->password,
        ];

        if ($request->filled ('password')) {
            $data ['password'] = bcrypt($request->password);

        }
        $user->update($data);

        return redirect('/users')->with('status', 'User Updated successfully with roles!');

    }

    public function destroy(User $user)
    {

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Deleted successfully');
    }

    public function show(User $user)
    {
        $user->load('tasks','department');
        return view('users.show', compact('user'));
    }

}
