@extends('site.master')

@section('title', 'Home - MyTasks')
@section('page-title', 'Today Tasks')

@section('styles')
    <!-- CSS إضافي خاص بالصفحة -->
@endsection

@section('content')

<!-- One Day Tasks -->
<div class="day-section">
    <div class="day-title">Today</div>

    <div class="task-card">
        <div class="task-info">
            <div class="task-name">Go to Gym</div>
            <div class="task-time">09:00 AM - 11:00 AM</div>
            <div class="task-desc">Leg day training at the fitness center</div>
        </div>
        <div class="task-actions">
            <button title="Edit"><i class="fas fa-edit"></i></button>
            <button title="Done" onclick="markDone(this)"><i class="fas fa-check"></i></button>
            <button title="Delete" onclick="deleteTask(this)"><i class="fas fa-trash"></i></button>
        </div>
    </div>

    <div class="task-card">
        <div class="task-info">
            <div class="task-name">Team Meeting</div>
            <div class="task-time">02:00 PM - 03:30 PM</div>
            <div class="task-desc">Weekly project status update</div>
        </div>
        <div class="task-actions">
            <button title="Edit"><i class="fas fa-edit"></i></button>
            <button title="Done" onclick="markDone(this)"><i class="fas fa-check"></i></button>
            <button title="Delete" onclick="deleteTask(this)"><i class="fas fa-trash"></i></button>
        </div>
    </div>
</div>

<div class="day-section">
    <div class="day-title">Tomorrow</div>

    <div class="task-card">
        <div class="task-info">
            <div class="task-name">Dentist Appointment</div>
            <div class="task-time">10:30 AM - 11:30 AM</div>
            <div class="task-desc">Regular checkup at City Dental Clinic</div>
        </div>
        <div class="task-actions">
            <button title="Edit"><i class="fas fa-edit"></i></button>
            <button title="Done" onclick="markDone(this)"><i class="fas fa-check"></i></button>
            <button title="Delete" onclick="deleteTask(this)"><i class="fas fa-trash"></i></button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function markDone(el) {
    el.closest('.task-card').classList.toggle('done');
}

function deleteTask(el) {
    el.closest('.task-card').remove();
}
</script>
@endsection
