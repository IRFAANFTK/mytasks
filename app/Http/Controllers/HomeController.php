<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

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
    public function index()
    {
        $createdTasks = Task::whereNull('started_at')->whereNull('ended_at')->get();
        $inProgressTasks = Task::whereNotNull('started_at')->whereNull('ended_at')->get();
        $doneTaks = Task::whereNotNull('started_at')->whereNotNull('ended_at')->get();

        return view('home', compact('createdTasks','inProgressTasks','doneTaks'));
    }
}
