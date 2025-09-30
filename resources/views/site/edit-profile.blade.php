@extends('site.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('siteasset/css/edit_profile.css') }}">
@endsection

@section('content')
    <div class="main">
        <div class="profile-form-container">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>

                <div class="form-group password-wrapper">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control"
                        placeholder="Enter current password">
                    <i class="fas fa-eye toggle-password" onclick="togglePassword(this)"></i>
                </div>

                <div class="form-group password-wrapper">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                    <i class="fas fa-eye toggle-password" onclick="togglePassword(this)"></i>
                </div>

                <div class="form-group password-wrapper">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control"
                        placeholder="Re-enter new password">
                    <i class="fas fa-eye toggle-password" onclick="togglePassword(this)"></i>
                </div>
                <div class="form-actions">
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function togglePassword(el) {
            const input = el.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                el.classList.remove('fa-eye');
                el.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                el.classList.remove('fa-eye-slash');
                el.classList.add('fa-eye');
            }
        }
    </script>
@endsection
