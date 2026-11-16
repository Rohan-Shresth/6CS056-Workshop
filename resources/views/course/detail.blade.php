@extends('layout')

@section('title', 'Course Details')

@section('content')
    <h1>Course Details</h1>
    <table>
        <tbody>
            <tr><th>ID</th><td>{{ $course->id }}</td></tr>
            <tr><th>Name</th><td>{{ $course->name }}</td></tr>
            <tr><th>Description</th><td>{{ $course->description ?: '—' }}</td></tr>
            <tr><th>Duration (weeks)</th><td>{{ $course->duration }}</td></tr>
            <tr><th>Fee</th><td>{{ number_format((float) $course->fee, 2) }}</td></tr>
            <tr><th>Difficulty</th><td>{{ $course->difficulty }}</td></tr>
            <tr><th>Status</th><td>{{ $course->is_active ? 'Active' : 'Inactive' }}</td></tr>
        </tbody>
    </table>
    <p class="actions">
        <a class="button" href="{{ route('courses.edit', $course) }}">Edit Course</a>
        <a class="button secondary" href="{{ route('courses.index') }}">Back to Courses</a>
    </p>
@endsection
