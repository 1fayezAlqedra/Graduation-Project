<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 Library for alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('siteasset/css/style.css') }}">
    @yield('styles')
</head>

<body>
    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <!-- Logo -->
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('siteasset/images/logo/logo.png') }}" alt="Logo">
                MyTasks
            </a>
        </div>
        <!-- Navigation Links -->
        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}"><i
                        class="fas fa-home"></i>Home</a></li>
            <li><a href="{{ url('/tasks') }}"><i class="fas fa-tasks"></i>Tasks</a></li>
            <li><a href="{{ url('/calendar') }}"><i class="fas fa-calendar-alt"></i>Calendar</a></li>
            <li><a href="{{ url('/profile') }}"><i class="fas fa-user"></i>Profile</a></li>
            <li><a href="{{ url('/settings') }}"><i class="fas fa-cog"></i>Settings</a></li>
            <li><a href="{{ url('/aboutUs') }}"><i class="fas fa-user-tie"></i> About Us</a></li>

        </ul>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
            <div class="welcome-section">
                @auth
                    Welcome, {{ Auth::user()->name }}
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="logout-btn" type="submit">Logout</button>
                    </form>

                @endauth
            </div>
        </div>

        <!-- Page Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer>
            <p>&copy; {{ date('Y') }} MyTasks. All rights reserved.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('siteasset/js/script.js') }}"></script>
    @yield('scripts')
</body>

</html>
