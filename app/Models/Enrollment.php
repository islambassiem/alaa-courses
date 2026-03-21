<?php

namespace App\Models;

use Database\Factories\EnrollmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $status
 *
 * @use HasFactory<EnrollmentFactory>
 */
class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'session_id',
        'payment_intent',
        'payment_status',
        'amount_total',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Course, $this>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100,
        ]);
    }

    public function updateProgress(int $percentage): void
    {
        $this->update([
            'progress_percentage' => min(100, max(0, $percentage)),
        ]);

        if ($percentage >= 100) {
            $this->markAsCompleted();
        }
    }

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
            'completed_at' => 'datetime',
            'progress_percentage' => 'integer',
        ];
    }
}
