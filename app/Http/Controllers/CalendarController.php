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
            $dueAt = strtotime($task->due_at);
            $endedAt = $task->ended_at ? strtotime($task->ended_at) : null;
            $now = strtotime(now());
            if ($endedAt !== null) {
                if ($endedAt <= $dueAt) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
            } else {
                if ($now > $dueAt) {
                    $color = 'red';
                } else {
                    $color = 'gray';
                }
            }
            return [
                'title' => $task->name,
                'start' => $task->due_at,
                'color' => $color,
                'url' => route('tasks.show', $task->id),
            ];
        });


        return response()->json($events);

    }
}
