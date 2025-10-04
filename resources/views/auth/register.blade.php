<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Mastery | Register</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('siteasset/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="luxury-container">
        <!-- Priority Advice Section -->
        <div class="priority-section">
            <div class="priority-content">
                <h2 class="priority-title">Start Your Productivity Journey</h2>
                <p class="priority-tip">By registering today, you're taking the first step toward mastering your time.</p>
                <p class="priority-quote">"Time isn't the main thing. It's the only thing."</p>
                <p class="priority-author">- Miles Davis</p>
            </div>
        </div>

        <!-- Register Section -->
        <div class="register-section">
            <div class="register-header">
                <div class="logo-form mb-10">
                    <div class="logo-icon">TM</div>
                    <div class="logo-text">TIME<span>MASTERY</span></div>
                </div>
                <h2 class="register-title">Create Your Account</h2>
                <p class="register-subtitle">Join us to unlock your full productivity potential</p>
            </div>

            <!-- Breeze Register Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group-auth">
                    <label for="name" class="form-label-auth">Full Name</label>
                    <input id="name" type="text" name="name" class="form-control-auth"
                        value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group-auth mt-4">
                    <label for="email" class="form-label-auth">Email Address</label>
                    <input id="email" type="email" name="email" class="form-control-auth"
                        value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group-auth mt-4">
                    <label for="password" class="form-label-auth">Password</label>
                    <input id="password" type="password" name="password" class="form-control-auth" required
                        autocomplete="new-password">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group-auth mt-4">
                    <label for="password_confirmation" class="form-label-auth">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="form-control-auth" required autocomplete="new-password">
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end mt-4">
                    <a class="forgot-password" href="{{ route('login') }}">
                        Already registered?
                    </a>

                    <button type="submit" class="btn-auth btn-primary-auth ms-3">
                        REGISTER
                    </button>
                </div>
            </form>

            <!-- Login Redirect -->
            <div class="login-section-auth mt-4">
                <p class="login-text">Already have an account?</p>
                <button type="button" class="btn-auth btn-secondary-auth"
                    onclick="window.location.href='{{ route('login') }}'">LOGIN</button>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('siteasset/js/script.js') }}"></script>
</body>

</html>
