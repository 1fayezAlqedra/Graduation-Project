@extends('site.master')
@section('content')

<!-- ===== MAIN CONTENT ===== -->
<div class="main">

    <!-- Add Task Form -->
    <div class="form-container">
        <form action="{{ route('tasks.store') }}" method="POST" id="taskForm">
            @csrf

            <div class="form-group mb-3">
                <label class="form-label">Task Name</label>
                <input type="text" name="title" class="form-control" placeholder="Enter task name" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Enter task description"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date & Time</label>
                    <input type="text" name="start_time" id="start_time" class="form-control datetimepicker" placeholder="Select start date & time" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date & Time</label>
                    <input type="text" name="end_time" id="end_time" class="form-control datetimepicker" placeholder="Select end date & time" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-control">
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Task</button>
            </div>
        </form>
    </div>
</div>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- SweetAlert2 CSS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr(".datetimepicker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today"
    });

    // تحقق من وجود فلاش ميسج للنجاح
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
