@extinds('site.master')

@section('content')
    <!-- Profile Section -->
    <div class="profile-container">
        <div class="profile-picture">
            <i class="fas fa-user"></i>
        </div>
        <div class="profile-info">
            <h2>Sobhi</h2>
            <p>sobhi@example.com</p>

            <div class="profile-stat">
                <span>Total Tasks</span>
                <span>47</span>
            </div>
            <div class="profile-stat">
                <span>Completed Tasks</span>
                <span>32</span>
            </div>
            <div class="profile-stat">
                <span>Pending Tasks</span>
                <span>15</span>
            </div>
            <div class="profile-stat">
                <span>Member Since</span>
                <span>Jan 2024</span>
            </div>

            <div class="form-actions" style="margin-top: 20px;">
                <button class="btn btn-primary" onclick="window.location.href='edit-profile.html'">Edit Profile</button>
            </div>
        </div>
    </div>
@endsection
