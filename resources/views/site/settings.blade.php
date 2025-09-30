@extends('site.master')

@section('title', 'Settings - MyApp')

@section('styles')
    <link rel="stylesheet" href="{{ asset('siteasset/css/settings.css') }}">
@endsection

@section('content')

<div class="settings-container">

    <!-- Account Info -->
    <div class="section">
        <h2>Account Information</h2>
        <form method="POST" action="{{ route('settings.update', auth()->id()) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ $user->email }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <!-- Security -->
    <div class="section">
        <h2>Security</h2>
        <form method="POST" action="{{ route('settings.update', auth()->id()) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password">
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="new_password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>

    <!-- Preferences -->
    <div class="section">
        <h2>Preferences</h2>
        <form method="POST" action="{{ route('settings.update', auth()->id()) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Reminders</label>
                <label class="switch">
                    <input type="checkbox" name="reminders" {{ $user->reminders ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Save Preferences</button>
        </form>
    </div>

    <!-- Account Management -->
    <div class="section">
        <h2>Account Management</h2>
        <form method="POST" action="{{ route('settings.destroy', auth()->id()) }}">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" onclick="alert('Download feature not implemented yet')">Download My Data</button>
            <button type="submit" class="btn btn-danger" onclick="return confirm('⚠️ Are you sure you want to delete your account? This action cannot be undone.')">Delete Account</button>
        </form>
    </div>

</div>

@endsection
