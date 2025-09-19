@extends('site.master')

@section('title', 'Home - MyTasks')
@section('page-title', 'Today Tasks')

@section('styles')
<style>
    .day-section {
        max-width: 900px;
        margin: 50px auto;
        padding: 0 15px;
    }

    .day-title {
        text-align: center;
        font-size: 1.8rem;
        margin-bottom: 30px;
        font-weight: bold;
    }

    .task-card {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
        background-color: #fff;
    }

    .task-card.completed {
        background-color: #f0f0f0;
    }

    .task-card.completed .task-name,
    .task-card.completed .task-desc {
        text-decoration: line-through;
        color: #999;
    }

    .task-info {
        flex: 1;
    }

    .task-name {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .priority {
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: bold;
        margin-left: 10px;
        color: #fff;
    }

    .priority-high { background-color: #e74c3c; }
    .priority-medium { background-color: #f39c12; }
    .priority-low { background-color: #2ecc71; }

    .task-time {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 10px;
    }

    .task-desc {
        font-size: 1rem;
        color: #333;
    }

    .task-actions button {
        border: none;
        background: none;
        margin-left: 10px;
        cursor: pointer;
        font-size: 1.1rem;
        color: #555;
        transition: color 0.2s;
    }

    .task-actions button:hover:not(:disabled) {
        color: #000;
    }

    .task-actions button:disabled {
        cursor: not-allowed;
        color: #aaa;
    }

    .no-tasks-message {
        text-align: center;
        margin-top: 100px;
    }

    .no-tasks-message p {
        margin-bottom: 20px;
        font-size: 1.2rem;
    }

    .btn-add-task {
        display: inline-block;
        padding: 10px 25px;
        background-color: #3498db;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn-add-task:hover { background-color: #2980b9; }
</style>
@endsection

@section('content')
@php
    use Carbon\Carbon;
    $today = Carbon::now();
    $todayFormatted = $today->format('l - Y-m-d');
    $todayTasks = $tasks->filter(fn($task) => $task->start_time->isSameDay($today));
@endphp

<div class="day-section">
    <div class="day-title">{{ $todayFormatted }}</div>

    @if ($todayTasks->isEmpty())
        <div class="no-tasks-message">
            <p>There are no tasks for today 🎉</p>
            <p>Start adding your tasks to stay organized and productive!</p>
            <a href="{{ route('tasks.create') }}" class="btn-add-task">Add Task Now</a>
        </div>
    @else
        @foreach ($todayTasks as $task)
            <div class="task-card @if($task->completed) completed @endif">
                <div class="task-info">
                    <div class="task-name">
                        {{ $task->title }}
                        @if ($task->priority == 'High') <span class="priority priority-high">High</span>
                        @elseif($task->priority == 'Medium') <span class="priority priority-medium">Medium</span>
                        @elseif($task->priority == 'Low') <span class="priority priority-low">Low</span>
                        @endif
                    </div>
                    <div class="task-time">{{ $task->start_time->format('h:i A') }} - {{ $task->end_time->format('h:i A') }}</div>
                    <div class="task-desc">{{ $task->description }}</div>
                </div>
                <div class="task-actions">
                    <button title="Edit" onclick="window.location.href='{{ route('tasks.edit', $task->id) }}'" @if($task->completed) disabled @endif>
                        <i class="fas fa-edit"></i>
                    </button>

                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button title="Done" @if($task->completed) disabled @endif>
                            <i class="fas fa-check"></i>
                        </button>
                    </form>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Delete" @if($task->completed) disabled @endif>
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif
@endsection
