@extends('site.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('siteasset/css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('content')
    <div class="profile-container">
        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>

            <div class="profile-stats">
                <div class="profile-stat">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Total Tasks</span>
                    <span>{{ $totalTasks }}</span>
                </div>

                <div class="profile-stat">
                    <i class="fa-solid fa-check status-completed"></i>
                    <span>Completed</span>
                    <span>{{ $completedTasks }}</span>
                </div>

                <div class="profile-stat">
                    <i class="fa-solid fa-hourglass-half status-pending"></i>
                    <span>Pending</span>
                    <span>{{ $pendingTasks }}</span>
                </div>

                <div class="profile-stat">
                    <i class="fa-solid fa-calendar"></i>
                    <span>Member Since</span>
                    <span>{{ $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}</span>
                </div>
            </div>

            <div class="form-actions">
                <a style="text-decoration: none"href="{{ route('profile.edit') }}" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Profile
                </a>
            </div>
        </div>

        <!-- الشارت أسفل الكروت -->
        <div class="chart-container">
            <h3>Task Overview</h3>
            <canvas id="taskChart"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- chart  Js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('taskChart').getContext('2d');
        const taskChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [{{ $completedTasks }}, {{ $pendingTasks }}],
                    backgroundColor: ['#1b998b', '#f39c12'],
                    borderColor: '#1b263b',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
