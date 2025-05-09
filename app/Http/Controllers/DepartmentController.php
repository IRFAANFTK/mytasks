<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::latest()->paginate(2);
        return view('departments.index', [
            'departments' => $departments
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $departments = Department::all();
        return view('departments.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        Department::create([
        'name' => $request->department
        ]);
        return redirect()->route('departments.index')
            ->withSuccess('New Department is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.show', [
            'department' => $department
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', [
            'department' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, Department $department) :  RedirectResponse
    {
        $department->update($request->all());
        return redirect()->back()
            ->withSuccess('Department is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department) : RedirectResponse
    {
        $department->delete();
        return redirect()->route('departments.index')
            ->withSuccess('Department is deleted successfully.');
    }
}
