@extends('site.master')

@section('title', 'Calendar - MyTasks')

@section('styles')
<link rel="stylesheet" href="{{ asset('siteasset/css/calendar.css') }}">

@endsection

@section('content')
<div class="calendar-container">
    <!-- Header -->
    <div class="calendar-header">
        <a href="{{ route('calendar.index', ['month' => $currentDate->copy()->subMonth()->format('Y-m')]) }}" class="nav-btn">&lt;</a>
        <h2>{{ $currentDate->format('F Y') }}</h2>
        <a href="{{ route('calendar.index', ['month' => $currentDate->copy()->addMonth()->format('Y-m')]) }}" class="nav-btn">&gt;</a>
    </div>

    <!-- Weekdays -->
    <div class="weekdays">
        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
            <div>{{ $day }}</div>
        @endforeach
    </div>

    <!-- Days grid -->
    <div class="days">
        @php
            $firstDayOfWeek = $monthStart->dayOfWeek;
        @endphp

        {{-- فراغات قبل بداية الشهر --}}
        @for($i = 0; $i < $firstDayOfWeek; $i++)
            <div class="day empty"></div>
        @endfor

        {{-- أيام الشهر --}}
        @for($day = 1; $day <= $monthEnd->day; $day++)
            @php
                $dayStr = str_pad($day, 2, '0', STR_PAD_LEFT);
                $dayTasks = $tasks->get($dayStr, collect());
            @endphp
            <div class="day" data-day="{{ $day }}" data-tasks='@json($dayTasks->map(fn($t)=>[
                "title"=>$t->title,
                "description"=>$t->description,
                "priority"=>$t->priority
            ])->values())'>
                <div class="date-number">{{ $day }}</div>

                <div class="tasks-wrapper">
                    @foreach($dayTasks->take(2) as $i => $task)
                        <div class="task {{ strtolower($task->priority) }}">
                            {{ $i+1 }}. {{ $task->title }}
                            <div class="task-details">{{ $task->description }}</div>
                        </div>
                    @endforeach
                </div>

                @if(count($dayTasks) > 2)
                    <div class="task-pagination">
                        <button class="task-page-btn prev">‹</button>
                        <span>+{{ count($dayTasks)-2 }} More</span>
                        <button class="task-page-btn next">›</button>
                    </div>
                @endif

                <button class="add-task-btn" onclick="window.location.href='{{ route('tasks.create') }}'">
                    + Add Task
                </button>
            </div>
        @endfor
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const daysContainer = document.querySelector('.days');
    const taskPageIndex = {};

    daysContainer.addEventListener('click', e => {
        if(e.target.classList.contains('task-page-btn')){
            const dayDiv = e.target.closest('.day');
            const day = dayDiv.dataset.day;
            const tasks = JSON.parse(dayDiv.dataset.tasks);
            const tasksPerPage = 2;

            if(!taskPageIndex[day]) taskPageIndex[day] = 0;
            let newIndex = taskPageIndex[day] + (e.target.classList.contains('prev') ? -1 : 1);

            const maxPage = Math.ceil(tasks.length / tasksPerPage) - 1;
            if(newIndex < 0) newIndex = 0;
            if(newIndex > maxPage) newIndex = maxPage;
            taskPageIndex[day] = newIndex;

            // عرض المهام
            const wrapper = dayDiv.querySelector('.tasks-wrapper');
            wrapper.innerHTML = '';
            const start = newIndex * tasksPerPage;
            const end = start + tasksPerPage;
            tasks.slice(start, end).forEach((task,i)=>{
                wrapper.innerHTML += `
                <div class="task ${task.priority?.toLowerCase() ?? 'normal'}">
                    ${start+i+1}. ${task.title}
                    <div class="task-details">${task.description || ''}</div>
                </div>`;
            });

            // تحديث النص +N More
            const paginationSpan = dayDiv.querySelector('.task-pagination span');
            if(paginationSpan){
                if(end < tasks.length){
                    paginationSpan.textContent = `+${tasks.length - end} More`;
                } else {
                    paginationSpan.textContent = '';
                }
            }
        }
    });
});
</script>
@endsection
