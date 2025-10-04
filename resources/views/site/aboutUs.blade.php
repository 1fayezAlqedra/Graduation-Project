@extends('site.master')

@section('title', 'About Us - MyTasks')
@section('page-title', 'About Us')

@section('styles')
<link rel="stylesheet" href="{{ asset('siteasset/css/about_us.css') }}">
@endsection

@section('content')
<div class="about-container">
    <!-- Title -->
    <div class="section-title">
        <h2>About Us</h2>
        <p class="section-subtitle">We are a passionate team building practical and elegant web applications</p>
    </div>

    <!-- Team Members -->
    <div class="team-members">
        <!-- Fayez -->
        <div class="team-member">
            <div class="member-image">
                <i class="fas fa-user-tie"></i>
            </div>
            <h3 class="member-name">Fayez Alqedra</h3>
            <p class="member-role">Team Leader — Backend & Database</p>
            <p class="member-desc">Leader of the team, specialized in backend development and database design.</p>
            <div class="member-degree"><i class="fas fa-graduation-cap"></i> Computer Science</div>
            <div class="member-university">Islamic University Of Gaza</div>
        </div>

        <!-- Omar -->
        <div class="team-member">
            <div class="member-image">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h3 class="member-name">Omar Alhallaq</h3>
            <p class="member-role">Frontend Developer</p>
            <p class="member-desc">Focused on building modern and responsive user interfaces.</p>
            <div class="member-degree"><i class="fas fa-graduation-cap"></i> Mobile Computing & Smartphone Apps</div>
            <div class="member-university">Islamic University Of Gaza</div>
        </div>

        <!-- Nour -->
        <div class="team-member">
            <div class="member-image">
                <i class="fas fa-vials"></i>
            </div>
            <h3 class="member-name">Nour Aldeen Alfarra</h3>
            <p class="member-role">Tester — Backend & Database</p>
            <p class="member-desc">Responsible for testing and ensuring quality of backend systems and databases.</p>
            <div class="member-degree"><i class="fas fa-graduation-cap"></i> Computer Science</div>
            <div class="member-university">Islamic University Of Gaza</div>
        </div>

        <!-- Sobhi -->
        <div class="team-member">
            <div class="member-image">
                <i class="fas fa-paint-brush"></i>
            </div>
            <h3 class="member-name">Sobhi Ahmed</h3>
            <p class="member-role">Frontend Developer</p>
            <p class="member-desc">Works on creating attractive and responsive user interfaces.</p>
            <div class="member-degree"><i class="fas fa-graduation-cap"></i> Mobile Computing & Smartphone Apps</div>
            <div class="member-university">Islamic University Of Gaza</div>
        </div>
    </div>

    <!-- Skills Section -->
    <div class="skills-section">
        <div class="section-title">
            <h2>Our Skills</h2>
        </div>

        <div class="skills-grid">
            <div class="skill-card">
                <div class="skill-icon"><i class="fas fa-database"></i></div>
                <div class="skill-title">Databases</div>
                <div class="skill-desc">Designing efficient databases with high performance and structured queries.</div>
            </div>

            <div class="skill-card">
                <div class="skill-icon"><i class="fab fa-laravel"></i></div>
                <div class="skill-title">Backend — Laravel</div>
                <div class="skill-desc">Building APIs, business logic, and secure systems with Laravel & PHP.</div>
            </div>

            <div class="skill-card">
                <div class="skill-icon"><i class="fab fa-js-square"></i></div>
                <div class="skill-title">Frontend — JavaScript</div>
                <div class="skill-desc">Creating dynamic interactions with JavaScript, HTML, CSS, and Bootstrap.</div>
            </div>

            <div class="skill-card">
                <div class="skill-icon"><i class="fas fa-project-diagram"></i></div>
                <div class="skill-title">Project Analysis & Management</div>
                <div class="skill-desc">Requirement analysis, task breakdown, and project management to ensure delivery on time.</div>
            </div>
        </div>
    </div>
</div>
@endsection
