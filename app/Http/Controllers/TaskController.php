<?php

namespace App\Http\Controllers;


use App\Exports\TasksExport;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function index()
    {


        $tasks=Task::orderBy('name', 'asc')->get();
        return view('tasks.index',compact('tasks'));


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

    public function show(Task $task)
    {
       $task->load('assignee');
       return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $users = User::all();
        $task->load('assignee');

        return view('tasks.edit', [
            'users' => $users,
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return redirect()->back()
            ->withSuccess('Task is updated successfully.');

    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')
            ->withSuccess('Task is deleted successfully.');
    }


    public function start(Task $task)
    {
        $task->started_at = now();
        $task->save();
        return redirect()->back()->withSuccess('Task is updated successfully.');
    }

    public function end(Task $task)
    {
        $task->ended_at= now();
        $task->save();
        return redirect()->back()->withSuccess('Task is updated successfully.');
    }


    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->back()->withSuccess('Task is deleted successfully.');
    }

     public function export()
     {
         return Excel::download(new TasksExport, 'tasks.xlsx');
     }

}
