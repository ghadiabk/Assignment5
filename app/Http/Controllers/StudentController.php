<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // Display a list of students
    public function index(Request $request)
    {
        $query = Student::query();
    
    if ($request->has('search') && !empty($request->search)) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    
    if ($request->has('min_age') && !empty($request->min_age)) {
        $query->where('age', '>=', $request->min_age);
    }
    
    if ($request->has('max_age') && !empty($request->max_age)) {
        $query->where('age', '<=', $request->max_age);
    }
    
    $students = $query->get();
    
    if ($request->ajax()) {
        return view('students.partials.studenttable', compact('students'));
    }
    
    return view('students.index', compact('students'));
    }

    // Show the form to create a new student
    public function create(Request $request)
    {
        return view('students.create');
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:25'
        ]);
    
        Student::create($request->all());
    
        return redirect()->route('students.index')
                         ->with('success', 'Student added successfully!');
    }

    // Store a newly created student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age'  => 'required|integer|min:18|max:25',
        ]);

        Student::create([
            'name' => $request->name,
            'age'  => $request->age,
        ]);

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function show($id) {}

    public function edit(Student $student) {
        return view('edit', compact('student'));
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'age'  => 'required|integer|min:18|max:25',
        ]);

        $student = Student::findOrFail($id);
        $student->update([
            'name' => $request->name,
            'age'  => $request->age,
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }
    public function destroy($id) {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
