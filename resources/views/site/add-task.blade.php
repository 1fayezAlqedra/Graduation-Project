@extends('site.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('siteasset/css/add_Task.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<div class="main">
    <div class="form-container">
        <h2>Add New Task</h2>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label>Task Name</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="form-group mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Start Date & Time</label>
                    <input type="text" name="start_time" id="start_time" class="form-control datetimepicker" placeholder="Select start date & time" value="{{ old('start_time') }}" readonly required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>End Date & Time</label>
                    <input type="text" name="end_time" id="end_time" class="form-control datetimepicker" placeholder="Select end date & time" value="{{ old('end_time') }}" readonly required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Priority</label>
                <select name="priority" class="form-control" required>
                    <option value="Low" {{ old('priority')=='Low' ? 'selected':'' }}>Low</option>
                    <option value="Medium" {{ old('priority')=='Medium' ? 'selected':'' }}>Medium</option>
                    <option value="High" {{ old('priority')=='High' ? 'selected':'' }}>High</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Task</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


// Flatpickr مع صيغة 24 ساعة
const startPicker = flatpickr("#start_time", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",  // 24 ساعة
    minDate: "today",
    onChange: function(selectedDates, dateStr) {
        endPicker.set('minDate', dateStr);
    }
});

const endPicker = flatpickr("#end_time", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",  // 24 ساعة
    minDate: "today"
});

// رسائل النجاح
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

// رسائل الأخطاء
@if($errors->any())
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    html: `<ul style="text-align:left;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>`
});
@endif
</script>
@endsection
