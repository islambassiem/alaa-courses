<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $courses_count
 */
class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * @return HasMany<Course, $this>
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * @return Attribute<string|null, string|null>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value): ?string => \is_string($value) ? ucfirst($value) : null,

            set: fn (mixed $value): ?string => \is_string($value) ? ucfirst($value) : null,
        );
    }
}
