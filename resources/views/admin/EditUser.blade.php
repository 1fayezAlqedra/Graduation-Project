<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Time Mastery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('adminasset/css/AddUser.css') }}">
</head>

<body>
    <div class="luxury-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <div class="logo-form">
                    <div class="logo-icon">TM</div>
                    <div class="logo-text">TIME<span>MASTERY</span></div>
                </div>
                <h1 class="header-title">Edit User</h1>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <h2 class="section-title">User Information</h2>

            <form id="editUserForm" method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT') {{-- عشان الـ update --}}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" id="confirmPassword" name="password_confirmation"
                                class="form-control" placeholder="Repeat password">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">User Role *</label>
                    <div class="user-role">
                        <div class="role-option">
                            <input type="radio" id="admin" name="role" value="admin"
                                {{ $user->role == 'admin' ? 'checked' : '' }}>
                            <label for="admin">Administrator</label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="user" name="role" value="user"
                                {{ $user->role == 'user' ? 'checked' : '' }}>
                            <label for="user">User</label>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <div>
                        <button type="button" class="btn-secondary" onclick="window.history.back()">Cancel</button>
                        <button type="submit" class="btn-primary">Update User</button>
                    </div>
                    <div>
                        <a href="{{ route('admin.index') }}" style="color: var(--primary); text-decoration: none;">
                            <i class="bi bi-arrow-left"></i> Back to Users List
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // لو المستخدم كتب باسورد جديد لازم تتأكد انه مطابق للتأكيد
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password && password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>

</html>
