<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * عرض صفحة الكالندر مع المهام للشهر الحالي أو المحدد
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // تحقق إذا تم تمرير شهر عبر GET (صيغة YYYY-MM)
        $monthParam = $request->query('month');
        if ($monthParam) {
            $currentDate = Carbon::createFromFormat('Y-m', $monthParam)->startOfMonth();
        } else {
            $currentDate = Carbon::now();
        }

        $monthStart = $currentDate->copy()->startOfMonth();
        $monthEnd = $currentDate->copy()->endOfMonth();

        // جلب المهام ضمن الشهر وتجميعها حسب اليوم
        $tasks = Task::where('user_id', $user->id)
            ->whereBetween('start_time', [$monthStart, $monthEnd])
            ->get()
            ->groupBy(function($task){
                return $task->start_time->format('d'); // تجميع حسب رقم اليوم (01, 02, ...)
            });

        return view('site.calendar', compact('tasks', 'currentDate', 'monthStart', 'monthEnd'));
    }
}
