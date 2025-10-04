<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $table = 'reminders';

    protected $fillable = [
        'task_id',
        'user_id',
        'remind_at',
        'notified',
    ];

    // علاقة Reminder مع Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
