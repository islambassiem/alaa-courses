<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection as ArrayCollection;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'image',
        'price',
        'original_price',
        'duration',
        'students_count',
        'rating',
        'is_new',
        'status',
        'objectives',
        'requirements',
        'instructor_id',
    ];

    /**
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function isEnrolledBy(User $user): bool
    {
        return $this->enrollments()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    #[Scope]
    protected function scopeCategory(Builder $query, Category $category)
    {
        return $query->where('category', $category);
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo<Instructor, $this>
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function hasReviewBy(User $user): bool
    {
        return $this->reviews()->where('user_id', $user->id)->exists();
    }

    /**
     * @return HasMany<Review, $this>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /** @return ArrayCollection<int, float> */
    public function ratingBreakdown(): ArrayCollection
    {
        $total = $this->reviews()->count();

        if ($total === 0) {
            return collect([5, 4, 3, 2, 1])->mapWithKeys(fn ($star) => [$star => 0.0]);
        }

        $grouped = $this->reviews()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating');

        /** @var ArrayCollection<int, int> $grouped */
        return $grouped->mapWithKeys(fn ($count, $rating) => [$rating => round(($count / $total) * 100)])
            ->union([5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0])
            ->sortKeysDesc();
    }

    /**
     * @return BelongsToMany<User, $this, Pivot>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function updateRating(): void
    {
        /** @var float $avgRating */
        $avgRating = $this->reviews()->avg('rating');
        $reviewsCount = $this->reviews()->count();

        $this->update([
            'rating' => $avgRating ? round($avgRating, 2) : null,
            'reviews_count' => $reviewsCount,
        ]);
    }

    /**
     * @return HasMany<Coupon, $this>
     */
    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function getActiveCoupon(): ?Coupon
    {
        /** @var Builder<Coupon> $query */
        $query = $this->coupons()->getQuery();

        return $query->active()->first();
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'original_price' => 'decimal:2',
            'rating' => 'decimal:2',
            'is_new' => 'boolean',
            'requirements' => 'array',
            'objectives' => 'array',
        ];
    }
}
