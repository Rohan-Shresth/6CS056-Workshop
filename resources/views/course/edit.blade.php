@extends('layout')

@section('title', 'Edit Course')

@section('content')
    <h1>Edit Course</h1>
    <form action="{{ route('courses.update', $course) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="field">
            <label for="name">Course Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $course->name) }}" maxlength="255" required>
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ old('description', $course->description) }}</textarea>
        </div>
        <div class="field">
            <label for="duration">Duration (weeks)</label>
            <input id="duration" name="duration" type="number" step="1" value="{{ old('duration', $course->duration) }}" required>
        </div>
        <div class="field">
            <label for="fee">Course Fee</label>
            <input id="fee" name="fee" type="number" step="any" value="{{ old('fee', $course->fee) }}" required>
        </div>
        <div class="field">
            <label for="difficulty">Difficulty</label>
            <select id="difficulty" name="difficulty" required>
                <option value="">Select difficulty</option>
                @foreach (['Easy', 'Medium', 'Hard'] as $difficulty)
                    <option value="{{ $difficulty }}" @selected(old('difficulty', $course->difficulty) === $difficulty)>{{ $difficulty }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <input type="hidden" name="is_active" value="0">
            <label>
                <input name="is_active" type="checkbox" value="1" @checked((string) old('is_active', $course->is_active ? '1' : '0') === '1')>
                Active
            </label>
        </div>
        <div class="actions">
            <button class="button" type="submit">Update Course</button>
            <a class="button secondary" href="{{ route('courses.index') }}">Cancel</a>
        </div>
    </form>
@endsection
