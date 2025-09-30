@extends('site.master')

@section('title', 'Home - MyTasks')
@section('page-title', 'Today Tasks')

@section('styles')
<link rel="stylesheet" href="{{ asset('siteasset/css/home.css') }}">
@endsection

@section('content')
@php
    use Carbon\Carbon;
    $today = Carbon::now();
    $todayFormatted = $today->format('l - Y-m-d');
    $todayTasks = $tasks->filter(fn($task) => $task->start_time->isSameDay($today));
@endphp

<div class="day-section" style="max-width:900px;margin:0 auto;">

    <!-- زر إضافة مهمة -->
    <div style="display:flex;justify-content:flex-end;margin-bottom:15px;">
        <a href="{{ route('tasks.create') }}" class="btn-add-task">+ Add Task</a>
    </div>

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
                    @if(!empty($task->description))
                        <div class="task-desc">{{ $task->description }}</div>
                    @endif
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
