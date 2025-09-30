<?php

namespace App\Http\Controllers\Home;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // فلترة من الريكوست
        $monthFilter = $request->input('month', Carbon::now()->month); // 1-12
        $weekFilter = $request->input('week_in_month', null); // رقم الأسبوع
        $sortFilter = $request->input('sort', ''); // 'priority' أو 'nearest'

        // اجلب كل مهام المستخدم
        $tasks = Task::where('user_id', $user->id);

        // حساب بداية ونهاية الشهر
        $year = Carbon::now()->year;
        $startOfMonth = Carbon::create($year, $monthFilter, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $monthFilter, 1)->endOfMonth();

        // حساب أسابيع الشهر لتظهر تواريخ البداية والنهاية
        $weeks = [];
        $current = $startOfMonth->copy();
        $weekNumber = 1;

        while ($current->lte($endOfMonth)) {
            $weekStart = $current->copy();
            $weekEnd = $current->copy()->addDays(6);
            if ($weekEnd->gt($endOfMonth)) {
                $weekEnd = $endOfMonth->copy();
            }

            $weeks[$weekNumber] = $weekStart->format('d/m') . ' - ' . $weekEnd->format('d/m');

            $current->addDays(7);
            $weekNumber++;
        }

        // فلترة المهام حسب الشهر
        $tasks = $tasks->whereBetween('start_time', [$startOfMonth, $endOfMonth]);

        // فلترة حسب الأسبوع إذا محدد
        if ($weekFilter && isset($weeks[$weekFilter])) {
            $range = explode(' - ', $weeks[$weekFilter]);
            $start = Carbon::createFromFormat('d/m', $range[0])->year($year);
            $end = Carbon::createFromFormat('d/m', $range[1])->year($year)->endOfDay();
            $tasks = $tasks->whereBetween('start_time', [$start, $end]);
        }

        // ترتيب حسب الفلتر
        if ($sortFilter === 'priority') {
            $tasks = $tasks->orderByRaw("FIELD(priority, 'High','Medium','Low')");
        } elseif ($sortFilter === 'nearest') {
            $tasks = $tasks->orderBy('start_time', 'asc');
        }

        $tasks = $tasks->get();

        return view('site.tasks', compact('tasks', 'weeks', 'monthFilter', 'weekFilter', 'sortFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('site.add-task');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['completed'] = false;

        $conflict = Task::where('user_id', auth()->id())
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'This time conflicts with another task.'])->withInput();
        }

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'The task has been added successfully.');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('site.edit-task', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        $conflict = Task::where('user_id', auth()->id())
            ->where('id', '!=', $task->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'This time conflicts with another task.'])->withInput();
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'The task has been modified successfully.');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id != auth()->id()) {
            abort(403);
        }
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function complete($id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id != auth()->id()) {
            abort(403);
        }
        $task->completed = true;
        $task->save();
        return redirect()->back()->with('success', 'Task marked as completed!');
    }
}
