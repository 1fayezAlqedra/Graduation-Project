<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Mastery | Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('siteasset/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-p...==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="luxury-container">
        <!-- Priority Advice Section -->
        <div class="priority-section">
            <div class="priority-content">
                <h2 class="priority-title">Master Your Priorities</h2>
                <p class="priority-tip">Focus on high-impact activities that align with your long-term goals.</p>
                <p class="priority-quote">"Until we can manage time, we can manage nothing else."</p>
                <p class="priority-author">- Peter Drucker</p>
            </div>
        </div>

        <!-- Login Section -->
        <div class="login-section">
            <div class="login-header">
                <div class="logo-form">
                    <div class="logo-icon">TM</div>
                    <div class="logo-text">TIME<span>MASTERY</span></div>
                </div>
                <h2 class="login-title">Welcome Back</h2>
                <p class="login-subtitle">Sign in to continue your productivity journey</p>
            </div>

            <!-- Breeze Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group-auth">
                    <label for="email" class="form-label-auth">Email Address</label>
                    <input id="email" type="email" name="email" class="form-control-auth" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group-auth">
                    <label for="password" class="form-label-auth">Password</label>
                    <input id="password" type="password" name="password" class="form-control-auth" required autocomplete="current-password">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif

                    <button type="submit" class="btn-auth btn-primary-auth ms-3">
                        LOGIN
                    </button>
                </div>
            </form>

            <div class="signup-section">
                <p class="signup-text">Don't have an account?</p>
                <button class="btn-auth btn-secondary-auth" onclick="window.location.href='{{ route('register') }}'">CREATE ACCOUNT</button>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('siteasset/js/script.js') }}"></script>
</body>
</html>
