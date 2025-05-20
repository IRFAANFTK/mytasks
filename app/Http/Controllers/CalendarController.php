<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }
    public function getTasks()
    {
        $tasks = Task::all();

        $events = $tasks->map(function ($task) {
            return [
                'title' => $task->name,
                'start' => $task->due_at,
            ];
        });
        return response()->json($events);
    }
}
