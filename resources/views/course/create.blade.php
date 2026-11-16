@extends('layout')

@section('title', 'Create Course')

@section('content')
    <h1>Create Course</h1>
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="field">
            <label for="name">Course Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" maxlength="255" required>
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <div class="field">
            <label for="duration">Duration (weeks)</label>
            <input id="duration" name="duration" type="number" step="1" value="{{ old('duration') }}" required>
        </div>
        <div class="field">
            <label for="fee">Course Fee</label>
            <input id="fee" name="fee" type="number" step="any" value="{{ old('fee') }}" required>
        </div>
        <div class="field">
            <label for="difficulty">Difficulty</label>
            <select id="difficulty" name="difficulty" required>
                <option value="">Select difficulty</option>
                @foreach (['Easy', 'Medium', 'Hard'] as $difficulty)
                    <option value="{{ $difficulty }}" @selected(old('difficulty') === $difficulty)>{{ $difficulty }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <input type="hidden" name="is_active" value="0">
            <label>
                <input name="is_active" type="checkbox" value="1" @checked(old('is_active', '0') === '1')>
                Active
            </label>
        </div>
        <div class="actions">
            <button class="button" type="submit">Save Course</button>
            <a class="button secondary" href="{{ route('courses.index') }}">Cancel</a>
        </div>
    </form>
@endsection
