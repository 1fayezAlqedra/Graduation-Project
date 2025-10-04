<?php

namespace App\Http\Controllers\Home;

use App\Models\Task;
use App\Models\Reminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    // عرض كل المهام للمستخدم الحالي
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->orderBy('start_time', 'asc')
            ->get();

        return view('site.tasks', compact('tasks'));
    }

    // عرض نموذج إضافة مهمة جديدة
    public function create()
    {
        return view('site.add-task');
    }


// Store A new Task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'start_time' => 'required|date_format:Y-m-d H:i|after_or_equal:now',
            'end_time' => 'required|date_format:Y-m-d H:i|after:start_time',
        ]);

        $start = Carbon::createFromFormat('Y-m-d H:i', $validated['start_time']);
        $end = Carbon::createFromFormat('Y-m-d H:i', $validated['end_time']);

        // Check for task overlap
        $overlap = Task::where('user_id', auth()->id())
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })->exists();

        if ($overlap) {
            return back()->withErrors(['start_time' => 'This task overlaps with another task'])->withInput();
        }

        // create Task
        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'],
            'start_time' => $start,
            'end_time' => $end,
            'completed' => false,
        ]);

        // Create a reminder (10 minutes before the task or as set by the user)
        $reminderMinutes = auth()->user()->reminder_before_minutes ?? 10;
        Reminder::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'remind_at' => $start->copy()->subMinutes($reminderMinutes),
            'notified' => false,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task added successfully with reminder.');
    }

    // عرض نموذج تعديل المهمة
    public function edit($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        return view('site.edit-task', compact('task'));
    }

    // تحديث المهمة
    public function update(Request $request, $id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'start_time' => 'required|date_format:Y-m-d H:i|after_or_equal:now',
            'end_time' => 'required|date_format:Y-m-d H:i|after:start_time',
        ]);

        $start = Carbon::createFromFormat('Y-m-d H:i', $validated['start_time']);
        $end = Carbon::createFromFormat('Y-m-d H:i', $validated['end_time']);

        // التحقق من تداخل المهام مع استثناء المهمة الحالية
        $overlap = Task::where('user_id', auth()->id())
            ->where('id', '!=', $task->id)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })->exists();

        if ($overlap) {
            return back()->withErrors(['start_time' => 'This task overlaps with another task'])->withInput();
        }

        // تحديث المهمة
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'],
            'start_time' => $start,
            'end_time' => $end,
        ]);

        // تحديث التذكير
        $reminderMinutes = auth()->user()->reminder_before_minutes ?? 10;
        $reminder = Reminder::firstOrCreate(
            ['task_id' => $task->id],
            [
                'user_id' => auth()->id(),
                'remind_at' => $start->copy()->subMinutes($reminderMinutes),
                'notified' => false,
            ]
        );

        $reminder->update([
            'remind_at' => $start->copy()->subMinutes($reminderMinutes),
            'notified' => false,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully with reminder.');
    }

    // حذف مهمة
    public function destroy($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        Reminder::where('task_id', $task->id)->delete();
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    // تعليم المهمة كمكتملة
    public function complete($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->update(['completed' => true]);
        Reminder::where('task_id', $task->id)->delete();

        return redirect()->back()->with('success', 'Task marked as completed and reminder removed.');
    }
}
