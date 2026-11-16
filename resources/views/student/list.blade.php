@extends('layout')

@section('title', 'Students')

@section('content')
    <div class="actions">
        <h1>Students</h1>
        <a class="button" href="{{ route('students.create') }}">Create Student</a>
    </div>

    @if ($students->isEmpty())
        <p class="empty">No students exist yet.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('students.show', $student) }}">View</a>
                                    <a href="{{ route('students.edit', $student) }}">Edit</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
