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
                $color = $endedAt <= $dueAt ? 'green' : 'red';
            } else {
                $color = $now > $dueAt ? 'red' : 'gray';
            }

            return [
                'id' => $task->id, // Required for drag and drop
                'title' => $task->name,
                'start' => $task->due_at,
                'color' => $color,
                'url' => route('tasks.show', $task->id),
            ];
        });

        return response()->json($events);
    }

    // Update task date when dragged
    public function updateDate(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Update due_at with the new dragged date
        $task->due_at = $request->newDate;
        $task->save();

        return response()->json(['success' => true]);
    }
}
