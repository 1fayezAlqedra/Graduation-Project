<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'start_time',
        'end_time',
        'completed',
    ] ; 



    // Relation With User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }










  protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'completed' => 'boolean',
    ];

    protected $attributes = [
        'priority' => 'medium',
        'completed' => false,
    ];
    // السكوبات
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }

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
