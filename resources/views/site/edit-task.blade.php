@extends('site.master')

@section('styles')
<!-- Custom CSS for edit task page -->
<link rel="stylesheet" href="{{ asset('siteasset/css/edit_Task.css') }}">
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<div class="main">
    <div class="form-container">
        <h2>Edit Task</h2>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST" id="taskForm">
            @csrf
            @method('PUT') <!-- Tell Laravel this is an update -->

            <!-- Task Title -->
            <div class="form-group mb-3">
                <label>Task Name</label>
                <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
            </div>

            <!-- Task Description -->
            <div class="form-group mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $task->description }}</textarea>
            </div>

            <div class="row">
                <!-- Start Date & Time -->
                <div class="col-md-6 mb-3">
                    <label>Start Date & Time</label>
                    <input type="text" name="start_time" id="start_time" class="form-control datetimepicker"
                        value="{{ $task->start_time?->format('Y-m-d H:i') }}" required>
                </div>

                <!-- End Date & Time -->
                <div class="col-md-6 mb-3">
                    <label>End Date & Time</label>
                    <input type="text" name="end_time" id="end_time" class="form-control datetimepicker"
                        value="{{ $task->end_time?->format('Y-m-d H:i') }}" required>
                </div>
            </div>

            <!-- Task Priority -->
            <div class="form-group mb-3">
                <label>Priority</label>
                <select name="priority" class="form-control" required>
                    <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Task</button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 JS for success & error messages -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Flatpickr JS for datetime picker -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Initialize Flatpickr for 24-hour format
    flatpickr(".datetimepicker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i", // 24-hour format
        minDate: "today"
    });

    // Show success message if session has success
    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    }).then(() => {
        window.location.href = "{{ route('tasks.index') }}";
    });
    @endif

    // Show validation errors using SweetAlert
    @if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: `<ul style="text-align:left;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>`
    });
    @endif
</script>
@endsection
