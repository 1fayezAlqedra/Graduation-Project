<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Time Mastery</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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
                <h1 class="header-title">Add New User</h1>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <h2 class="section-title">User Information</h2>

            <form id="addUserForm" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Enter full name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Enter email address" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Create a password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Confirm Password *</label>
                            <input type="password" id="confirmPassword" name="password_confirmation"
                                class="form-control" placeholder="Repeat password" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">User Role *</label>
                    <div class="user-role">
                        <div class="role-option">
                            <input type="radio" id="admin" name="role" value="admin">
                            <label for="admin">Administrator</label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="user" name="role" value="user" checked>
                            <label for="user">User</label>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <div>
                        <button type="button" class="btn-secondary" onclick="window.history.back()">Cancel</button>
                        <button type="submit" class="btn-primary">Add User</button>
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

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Form validation
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }

            // Additional validation can be added here

            // If using AJAX submission
            // e.preventDefault();
            // submitFormData();
        });

        // Example AJAX submission function
        /*
         function submitFormData() {
                const formData = new FormData(document.getElementById('addUserForm'));

                fetch('/api/users', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/admin/users?message=User added successfully';
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while adding the user');
                    });
            }
       */
    </script>
</body>

</html>
