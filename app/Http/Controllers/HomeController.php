<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        $user = Auth::user();
        $users = User::all();
        $departments = Department::all();

        $selectedUserId = $request->get('user_id');
        $selectedDepartmentId = $request->get('department_id');

        $query = Task::query();

// Only allow admin to filter or see everything
        if ($user->hasRole('admin')) {
            if ($selectedUserId) {
                $query->where('assignee_id', $selectedUserId);
            }

            if ($selectedDepartmentId) {
                $query->whereHas('user.department', function ($q) use ($selectedDepartmentId) {
                    $q->where('id', $selectedDepartmentId);
                });
            }
        } else {
// If not admin, force to see only their own tasks
            $query->where('user_id', $user->id);
        }

        $tasks = $query->get()->groupBy('status');

        return view('home', compact('tasks', 'users', 'departments', 'selectedUserId', 'selectedDepartmentId'));
    }
}
