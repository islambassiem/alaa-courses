<?php

namespace App\Models;

use Database\Factories\InstructorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $courses_count
 */
class Instructor extends Model
{
    /** @use HasFactory<InstructorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
    ];

    /**
     * @return HasMany<Course, $this>
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
