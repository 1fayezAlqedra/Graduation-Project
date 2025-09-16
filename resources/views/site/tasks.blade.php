@extends('site.master')
@section('content')
    <!-- Week Selector -->
    <div class="top-bar">
        <div class="dropdowns">
            <select>
                <option>Week 1</option>
                <option>Week 2</option>
                <option>Week 3</option>
            </select>
            <select>
                <option>March 2025</option>
                <option>April 2025</option>
            </select>
        </div>
        <button class="btn btn-primary" onclick="window.location.href='add-task.html'">
            <i class="fas fa-plus"></i> Add Task
        </button>
    </div>

    <!-- Tasks Container -->
    <div id="tasks-container">
        <!-- Monday -->
        <div class="day-section">
            <div class="day-title">Monday</div>
            <div class="task-card">
                <div class="task-info">
                    <div class="task-name">Code Review</div>
                    <div class="task-time">10:00 AM - 12:00 PM</div>
                    <div class="task-desc">Review backend API code for bugs and optimizations</div>
                </div>
                <div class="task-actions">
                    <button title="Edit" onclick="window.location.href='edit-task.html'"><i
                            class="fas fa-edit"></i></button>
                    <button title="Done" onclick="markDone(this)"><i class="fas fa-check"></i></button>
                    <button title="Delete" onclick="deleteTask(this)"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>

        <!-- Tuesday -->
        <div class="day-section">
            <div class="day-title">Tuesday</div>
            <div class="task-card">
                <div class="task-info">
                    <div class="task-name">Write Documentation</div>
                    <div class="task-time">01:00 PM - 03:00 PM</div>
                    <div class="task-desc">Document API endpoints and authentication flow</div>
                </div>
                <div class="task-actions">
                    <button title="Edit" onclick="window.location.href='edit-task.html'"><i
                            class="fas fa-edit"></i></button>
                    <button title="Done" onclick="markDone(this)"><i class="fas fa-check"></i></button>
                    <button title="Delete" onclick="deleteTask(this)"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>

        <!-- Wednesday -->
        <div class="day-section">
            <div class="day-title">Wednesday</div>
            <div class="task-card">
                <div class="task-info">
                    <div class="task-name">Client Presentation</div>
                    <div class="task-time">11:00 AM - 12:30 PM</div>
                    <div class="task-desc">Present new features and get feedback</div>
                </div>
                <div class="task-actions">
                    <button title="Edit" onclick="window.location.href='edit-task.html'"><i
                            class="fas fa-edit"></i></button>
                    <button title="Done" onclick="markDone(this)"><i class="fas fa-check"></i></button>
                    <button title="Delete" onclick="deleteTask(this)"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>

        <!-- Thursday -->
        <div class="day-section">
            <div class="day-title">Thursday</div>
            <div class="task-card">
                <div class="task-info">
                    <div class="task-name">Database Backup</div>
                    <div class="task-time">08:00 AM - 09:00 AM</div>
                    <div class="task-desc">Perform weekly backup of production database</div>
                </div>
                <div class="task-actions">
                    <button title="Edit" onclick="window.location.href='edit-task.html'"><i
                            class="fas fa-edit"></i></button>
                    <button title="Done" onclick="markDone(this)"><i class="fas fa-check"></i></button>
                    <button title="Delete" onclick="deleteTask(this)"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>

        <!-- Friday -->
        <div class="day-section">
            <div class="day-title">Friday</div>
            <div class="task-card">
                <div class="task-info">
                    <div class="task-name">Team Lunch</div>
                    <div class="task-time">01:00 PM - 02:30 PM</div>
                    <div class="task-desc">Casual lunch with the whole development team</div>
                </div>
                <div class="task-actions">
                    <button title="Edit" onclick="window.location.href='edit-task.html'"><i
                            class="fas fa-edit"></i></button>
                    <button title="Done" onclick="markDone(this)"><i class="fas fa-check"></i></button>
                    <button title="Delete" onclick="deleteTask(this)"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection
