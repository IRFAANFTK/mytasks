<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function create()
    {

        return view('departments.create');
    }

    public function store(Request $request)
    {
        Department::create([
            'name' => $request->input('name'),
        ]);
        $departments= Department::all();
        return view('departments.index', compact('departments'));
    }

    public function update(Request $request)
    {
        $department = Department::findOrFail($request->input('department_id'));
        $department->update([
            'name' => $request->input('name'),

        ]);
        return redirect()->route('departments.index');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    public function show($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.show', compact('department'));
    }
}
