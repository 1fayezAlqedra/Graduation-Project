<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها جماعياً (Mass Assignment)
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'due_date',
        'completed'
    ];

    /**
     * تحويل أنواع البيانات
     */
    protected $casts = [
        'due_date' => 'datetime',
        'completed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * القيم الافتراضية للحقول
     */
    protected $attributes = [
        'priority' => 'medium',
        'completed' => false,
    ];

    /**
     * العلاقة مع نموذج User (المستخدم)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع نموذج TimeSlot (الفواصل الزمنية)
     */
    public function timeSlots(): HasMany
    {
        return $this->hasMany(TimeSlot::class);
    }

    /**
     * العلاقة مع نموذج Reminder (التذكيرات)
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    /**
     * نطاق الاستعلام للمهام المكتملة
     */
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    /**
     * نطاق الاستعلام للمهام غير المكتملة
     */
    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }

    /**
     * نطاق الاستعلام للمهام ذات الأولوية العالية
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }








    public function markAsCompleted(): void
    {
        $this->update(['completed' => true]);
    }


    public function markAsIncomplete(): void
    {
        $this->update(['completed' => false]);
    }
}
