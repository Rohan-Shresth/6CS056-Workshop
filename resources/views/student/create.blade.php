@extends('layout')

@section('title', 'Create Student')

@section('content')
    <h1>Create Student</h1>
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="field">
            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" maxlength="255" required>
        </div>
        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" required>
        </div>
        <div class="field">
            <label for="phone">Phone</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" maxlength="20" required>
        </div>
        <div class="field">
            <label for="address">Address</label>
            <textarea id="address" name="address" maxlength="500">{{ old('address') }}</textarea>
        </div>
        <div class="field">
            <label for="date_of_birth">Date of Birth</label>
            <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}">
        </div>
        <div class="actions">
            <button class="button" type="submit">Save Student</button>
            <a class="button secondary" href="{{ route('students.index') }}">Cancel</a>
        </div>
    </form>
@endsection
