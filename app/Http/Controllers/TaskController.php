<?php

namespace App\Http\Controllers;


use App\Exports\TasksExport;
use App\Models\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function getTasks(Request $request)
    {
        $query = Task::with('user'); // <-- Add this line before the clones

        // Filter by user ID
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by department ID (only if user filter is not used)
        elseif ($request->filled('department_id')) {
            $userIds = User::where('department_id', $request->department_id)->pluck('id');
            $query->whereIn('user_id', $userIds);
        }

        $authUser = auth()->user();

        if(!$authUser->hasRole('admin')){
            $query->where('user_id', $authUser->id);
        }

        return response()->json([
            'created' => (clone $query)->whereNull('started_at')->whereNull('ended_at')->get(),
            'inProgress' => (clone $query)->whereNotNull('started_at')->whereNull('ended_at')->get(),
            'done' => (clone $query)->whereNotNull('started_at')->whereNotNull('ended_at')->get(),
        ]);
    }

    public function exportPdf()
    {
        $tasks = \App\Models\Task::with('user')->get();
        $pdf = Pdf::loadView('pdf.tasks', compact('tasks'));
        return $pdf->download('tasks.pdf');
    }




}
