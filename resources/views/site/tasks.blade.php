@extends('site.master')
@section('title', 'Tasks - MyTasks')
@section('page-title', 'Tasks')
@section('styles')
    <!-- نستخدم نفس ستايل الصفحة الرئيسية ليكون الشكل متطابق -->
    <link rel="stylesheet" href="{{ asset('siteasset/css/home.css') }}">
@endsection

@section('content')
    @php
        use Carbon\Carbon;

        // ===========================
        // 1. استلام الفلاتر من الرابط
        // ===========================
        $sortFilter = $sortFilter ?? request('sort', '');
        $monthFilter = $monthFilter ?? (int) request('month', Carbon::now()->month);
        $weekFilter = $weekFilter ?? (int) request('week', 1);

        // ===========================
        // 2. تحديد بداية ونهاية الشهر
        // ===========================
        $startOfMonth = Carbon::create(now()->year, $monthFilter, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // ===========================
        // 3. تحديد بداية ونهاية الأسبوع داخل الشهر
        // ===========================
        $weekStart = $startOfMonth->copy()->addDays(($weekFilter - 1) * 7);
        $weekEnd = $weekStart->copy()->addDays(6);
        if ($weekEnd->gt($endOfMonth)) {
            $weekEnd = $endOfMonth->copy();
        }

        // ===========================
        // 4. تصفية المهام حسب الفترة
        // ===========================
        $tasksInRange = $tasks->filter(function ($task) use ($weekStart, $weekEnd) {
            $startTime = Carbon::parse($task->start_time);
            return $startTime->between($weekStart, $weekEnd);
        });

        // ===========================
        // 5. ترتيب المهام حسب الفلتر
        // ===========================
        if ($sortFilter == 'priority') {
            $tasksInRange = $tasksInRange->sortByDesc(function ($task) {
                return match ($task->priority) {
                    'High' => 3,
                    'Medium' => 2,
                    'Low' => 1,
                };
            });
        } elseif ($sortFilter == 'nearest') {
            $tasksInRange = $tasksInRange->sortBy('start_time');
        }
    @endphp

    <div class="day-section">

        <!-- Header + Filters + Add Task Button -->
        <div
            style="max-width:900px;margin:0 auto 20px;display:flex;justify-content:space-between;align-items:center;padding:0 15px;">
            <h2 style="margin:0;font-size:1.6rem;">Tasks</h2>

            <div style="display:flex;gap:10px;align-items:center;">
                <form method="GET" action="{{ route('tasks.index') }}" style="margin:0;display:flex;gap:10px;">
                    <!-- ترتيب المهام -->
                    <select name="sort" onchange="this.form.submit()"
                        style="padding:8px 12px;border-radius:6px;border:1px solid #ddd;">
                        <option value="">-- Sort --</option>
                        <option value="priority" {{ $sortFilter == 'priority' ? 'selected' : '' }}>Priority</option>
                        <option value="nearest" {{ $sortFilter == 'nearest' ? 'selected' : '' }}>Nearest</option>
                    </select>

                    <!-- اختيار الشهر -->
                    <select name="month" onchange="this.form.submit()"
                        style="padding:8px 12px;border-radius:6px;border:1px solid #ddd;">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $monthFilter == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>

                    <!-- اختيار الأسبوع -->
                    <select name="week" onchange="this.form.submit()"
                        style="padding:8px 12px;border-radius:6px;border:1px solid #ddd;">
                        @for ($w = 1; $w <= 4; $w++)
                            <option value="{{ $w }}" {{ $weekFilter == $w ? 'selected' : '' }}>
                                {{ ['First', 'Second', 'Third', 'Fourth'][$w - 1] }} Week
                                ({{ $weekStart->copy()->addDays(($w - 1) * 7)->format('Y-m-d') }} -
                                {{ min($weekStart->copy()->addDays($w * 7 - 1), $endOfMonth)->format('Y-m-d') }})
                            </option>
                        @endfor
                    </select>
                </form>

                <!-- زر إضافة مهمة -->
                <a href="{{ route('tasks.create') }}" class="btn-add-task">+ Add Task</a>
            </div>
        </div>

        <!-- عرض الأيام السبعة من الأسبوع -->
        @for ($i = 0; $i < 7; $i++)
            @php
                $day = $weekStart->copy()->addDays($i);
                if ($day->gt($weekEnd)) {
                    continue;
                }

                $dayTasks = $tasksInRange->filter(function ($task) use ($day) {
                    return Carbon::parse($task->start_time)->isSameDay($day);
                });

                $dayTitle = $day->format('l - Y-m-d');
            @endphp

            <div style="max-width:900px;margin:0 auto 25px;padding:0 15px;">
                <div class="day-title">{{ $dayTitle }}</div>

                @if ($dayTasks->isEmpty())
                    <div class="no-tasks-message" style="max-width:900px;margin:15px auto;">
                        <p>No tasks for this day.</p>
                    </div>
                @else
                    @foreach ($dayTasks as $task)
                        <div class="task-card {{ $task->completed ? 'completed' : '' }}">
                            <div class="task-info">
                                <div class="task-name">
                                    {{ $task->title }}
                                    <span
                                        class="priority
                                    {{ $task->priority == 'High' ? 'priority-high' : ($task->priority == 'Medium' ? 'priority-medium' : 'priority-low') }}">
                                        {{ $task->priority }}
                                    </span>
                                </div>

                                <div class="task-time">
                                    {{ Carbon::parse($task->start_time)->format('h:i A') }} -
                                    {{ Carbon::parse($task->end_time)->format('h:i A') }}
                                </div>

                                @if (!empty($task->description))
                                    <div class="task-desc">{{ $task->description }}</div>
                                @endif
                            </div>

                            <div class="task-actions">
                                <button title="Edit"
                                    onclick="window.location.href='{{ route('tasks.edit', $task->id) }}'"
                                    @if ($task->completed) disabled @endif>
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('tasks.complete', $task->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button title="Mark as Done" @if ($task->completed) disabled @endif>
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" @if ($task->completed) disabled @endif>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endfor
    </div>
@endsection
