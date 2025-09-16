@extends('site.master')
@section('content')
    <!-- Settings Section -->
    <div class="settings-container">
        <div class="setting-item">
            <div>
                <h3>Email Notifications</h3>
                <p>Receive email notifications for new tasks</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>
        </div>

        <div class="setting-item">
            <div>
                <h3>Dark Mode</h3>
                <p>Enable dark theme</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>
        </div>

        <div class="setting-item">
            <div>
                <h3>Auto Backup</h3>
                <p>Automatically backup your tasks</p>
            </div>
            <label class="toggle-switch">
                <input type="checkbox">
                <span class="slider"></span>
            </label>
        </div>

        <div class="setting-item">
            <div>
                <h3>Language</h3>
                <p>Select your preferred language</p>
            </div>
            <select class="form-control" style="width: auto;">
                <option>English</option>
                <option>Arabic</option>
                <option>Spanish</option>
                <option>French</option>
            </select>
        </div>

        <div class="setting-item">
            <div>
                <h3>Date Format</h3>
                <p>Choose how dates are displayed</p>
            </div>
            <select class="form-control" style="width: auto;">
                <option>MM/DD/YYYY</option>
                <option>DD/MM/YYYY</option>
                <option>YYYY-MM-DD</option>
            </select>
        </div>

        <div class="setting-item">
            <div>
                <h3>Time Format</h3>
                <p>Choose 12-hour or 24-hour clock</p>
            </div>
            <select class="form-control" style="width: auto;">
                <option>12-hour</option>
                <option>24-hour</option>
            </select>
        </div>

        <div class="form-actions" style="margin-top: 20px;">
            <button class="btn btn-secondary">Reset to Default</button>
            <button class="btn btn-primary">Save Settings</button>
        </div>
    </div>
@endsection
