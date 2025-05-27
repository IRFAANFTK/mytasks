<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreatedMail;
use App\Mail\WelcomeEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

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
        $roles = Role::all();
        return view('users.create', [
            'departments' => $departments,
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'department_id' => 'required',
            'role' => 'required|exists:roles,name',
        ]);

        $plainPassword = $request->password;


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'department_id' => $request->department_id,
        ]);

        $user->assignRole($request->role);

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
        $roles = Role::all();
        return view('users.edit', [
            'user' => $user,
            'departments' => $departments,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',

        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled ('password')) {
            $data ['password'] = bcrypt($request->password);

        }
        $user->update($data);
        $user->syncRoles($request->role);

        return redirect('/users')->with('status', 'Utilisateur mis à jour avec succès avec les rôles !');

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

    public function editSettings()
    {
        return view('profile.settings', ['user' => auth()->user()]);
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle avatar
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Profil mis à jour.');
    }

}
