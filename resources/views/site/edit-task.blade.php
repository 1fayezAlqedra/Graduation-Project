@extends('site.master')
@section('content')

<!-- ===== MAIN CONTENT ===== -->
<div class="main">

    <!-- Edit Task Form -->
    <div class="form-container">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" id="taskForm">
            @csrf
            @method('PUT') <!-- مهم عشان Laravel يعرف انو Update -->

            <div class="form-group mb-3">
                <label class="form-label">Task Name</label>
                <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $task->description }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date & Time</label>
                    <input type="text" name="start_time" id="start_time" class="form-control datetimepicker" value="{{ $task->start_time->format('Y-m-d H:i') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date & Time</label>
                    <input type="text" name="end_time" id="end_time" class="form-control datetimepicker" value="{{ $task->end_time->format('Y-m-d H:i') }}" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-control">
                    <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Task</button>
            </div>
        </form>
    </div>
</div>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr(".datetimepicker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today"
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = "{{ route('tasks.index') }}";
        });
    @endif
</script>

@endsection
