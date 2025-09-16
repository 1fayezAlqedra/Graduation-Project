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
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                class="user-img" alt="{{ $user->name }}">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-left"></i> Logout</a>
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
            <img src="https://ui-avatars.com/api/?name=Admin+User&background=4361ee&color=fff" alt="User Image">
            <h5>{{ $user->name }}</h5>
            <p>{{ $user->email }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content p-4">
        <div class="stats-cards d-flex gap-3 mb-4">
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                @php
                    use App\Models\User;
                    $totalUsers = User::count();
                @endphp
                <i class="bi bi-people"></i>
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-list-task"></i>
                @php
                    use App\Models\Task;
                    $totalTasks = Task::count();
                @endphp
                <h3>{{ $totalTasks }}</h3>
                <p>Total Tasks</p>
            </div>
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-check-circle"></i>
                @php
                    $completedTasks = Task::where('completed', true)->count();
                @endphp
                <h3>{{ $completedTasks }}</h3>
                <p>Completed Tasks</p>
            </div>
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-clock"></i>
                @php
                    $pendingTasks = Task::where('completed', false)->count();
                @endphp
                <h3>{{ $pendingTasks }}</h3>
                <p>Pending Tasks</p>
            </div>
            <!-- بطاقة Canceled Tasks المضافة -->
            <div class="stat-card p-3 bg-light rounded shadow-sm">
                <i class="bi bi-x-circle"></i>
                @php
                    // إذا كان لديك حقل status في جدول tasks
                    // $canceledTasks = Task::where('status', 'canceled')->count();

                    // إذا لم يكن لديك حقل status، يمكنك استخدام completed مع due_date لتحديد المهام الملغاة
                    $canceledTasks = Task::where('completed', false)
                                         ->where('due_date', '<', now())
                                         ->count();
                @endphp
                <h3>{{ $canceledTasks }}</h3>
                <p>Canceled Tasks</p>
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
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <!-- زر التعديل -->
                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="window.location.href='{{ route('admin.users.edit', $user->id) }}'">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    {{-- Delete btn --}}
                                    <form id="delete-user-{{ $user->id }}"
                                        action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete('delete-user-{{ $user->id }}')">
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
