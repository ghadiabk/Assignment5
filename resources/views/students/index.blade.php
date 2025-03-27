
@extends('layout')
@section('title', 'Students')
@section('content')
<h2>Students</h2>

<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" id="search" class="form-control" placeholder="Search student...">
    </div>
    <div class="col-md-3">
        <input type="number" id="minAge" class="form-control" placeholder="Min age">
    </div>
    <div class="col-md-3">
        <input type="number" id="maxAge" class="form-control" placeholder="Max age">
    </div>
</div>

<div id="studentsTable">
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->age }}</td>
                <td>
                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function fetchStudents(search = '', minAge = '', maxAge = '') {
        $.ajax({
            url: "{{ route('students.index') }}",
            type: "GET",
            data: {
                search: search,
                min_age: minAge,
                max_age: maxAge
            },
            success: function(data) {
                $('#studentsTable').html(data);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    $('#search').keyup(function() {
        fetchStudents($(this).val(), $('#minAge').val(), $('#maxAge').val());
    });

    $('#minAge, #maxAge').change(function() {
        fetchStudents($('#search').val(), $('#minAge').val(), $('#maxAge').val());
    });
});
</script>
@endsection