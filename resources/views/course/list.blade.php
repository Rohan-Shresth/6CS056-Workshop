@extends('layout')

@section('title', 'Courses')

@section('content')
    <div class="actions">
        <h1>Courses</h1>
        <a class="button" href="{{ route('courses.create') }}">Create Course</a>
    </div>

    @if ($courses->isEmpty())
        <p class="empty">No courses exist yet.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Duration (weeks)</th>
                        <th>Fee</th>
                        <th>Difficulty</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->duration }}</td>
                            <td>{{ number_format((float) $course->fee, 2) }}</td>
                            <td>{{ $course->difficulty }}</td>
                            <td>{{ $course->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('courses.show', $course) }}">View</a>
                                    <a href="{{ route('courses.edit', $course) }}">Edit</a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST">
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
