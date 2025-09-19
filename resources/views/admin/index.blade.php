<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('adminasset/css/style.css') }}">

    <script src="{{ asset('adminasset/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('adminasset/js/admin.js') }}"></script>
</head>

<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-bell"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-gear"></i></a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($authUser->name) }}&background=random"
                                class="user-img" alt="{{ $authUser->name }}">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-left"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($authUser->name) }}&background=4361ee&color=fff"
                alt="User Image">
            <h5>{{ $authUser->name }}</h5>
            <p>{{ $authUser->email }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content p-4">
        <div class="stats-cards d-flex gap-3 mb-4">
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-people"></i>
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-list-task"></i>
                <h3>{{ $totalTasks }}</h3>
                <p>Total Tasks</p>
            </div>
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-check-circle"></i>
                <h3>{{ $completedTasks }}</h3>
                <p>Completed Tasks</p>
            </div>
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-clock"></i>
                <h3>{{ $pendingTasks }}</h3>
                <p>Pending Tasks</p>
            </div>
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-x-circle"></i>
                <h3>{{ $canceledTasks }}</h3>
                <p>Canceled/Overdue Tasks</p>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header d-flex justify-content-between align-items-center mb-3">
                <h2>User Management</h2>
                <button class="btn btn-primary" onclick="window.location.href='{{ route('admin.users.create') }}'">
                    Add New User
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->role }}</td>
                                <td>
                                    <!-- زر التعديل -->
                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="window.location.href='{{ route('admin.users.edit', $u->id) }}'">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- زر الحذف -->
                                    <form id="delete-user-{{ $u->id }}"
                                        action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete('delete-user-{{ $u->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
