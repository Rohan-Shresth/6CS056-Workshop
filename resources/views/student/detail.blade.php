@extends('layout')

@section('title', 'Student Details')

@section('content')
    <h1>Student Details</h1>
    <table>
        <tbody>
            <tr><th>ID</th><td>{{ $student->id }}</td></tr>
            <tr><th>Name</th><td>{{ $student->name }}</td></tr>
            <tr><th>Email</th><td>{{ $student->email }}</td></tr>
            <tr><th>Phone</th><td>{{ $student->phone }}</td></tr>
            <tr><th>Address</th><td>{{ $student->address ?: '—' }}</td></tr>
            <tr><th>Date of Birth</th><td>{{ $student->date_of_birth?->format('Y-m-d') ?? '—' }}</td></tr>
        </tbody>
    </table>
    <p class="actions">
        <a class="button" href="{{ route('students.edit', $student) }}">Edit Student</a>
        <a class="button secondary" href="{{ route('students.index') }}">Back to Students</a>
    </p>
@endsection
