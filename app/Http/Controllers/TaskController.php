<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tasks = Task::latest()->with('user')->paginate(5);

        return view('tasks.index', [
            'tasks' => $tasks
        ]);

    }

    public function create()
    {

        $users = User::all();
        return view('tasks.create', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        Task::create($request->all());
        return redirect()->route('tasks.index')
            ->withSuccess('New Tasks is added successfully.');
    }
    public function show($id)
    {
        $task= Task::findOrFail($id);
        return view('tasks.show', compact('task'));
    }


    public function edit(Task $task)
    {    $users = User::all();
        $task->load('assignee');
        return view('tasks.edit',
            [        'users' => $users,
                'task' => $task    ]);}

    public function update(Request $request)
    {
        $task = Task::findOrFail($request->input('task_id'));
        $task->update([
            'name' => $request->input('name'),
            'started_at' => $request->input('started_at'),
            'ended_at' => $request->input('ended_at'),
            'description' => $request->input('description'),
        ]);
        return redirect()->route('tasks.index');
    }

    public function destroy($id)
    {
        $task = task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }


}

