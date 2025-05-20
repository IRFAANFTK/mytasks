<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
// Admin sees everything
            $tasks = Task::latest()->take(5)->get();
            $totalUsers = User::count();
            return view('dashboard.admin', compact('user', 'tasks', 'totalUsers'));
        } else {
// Normal user sees their tasks
            $tasks = Task::where('user_id', $user->id)->latest()->take(5)->get();
            return view('dashboard.user', compact('user', 'tasks'));
        }
    }
}
