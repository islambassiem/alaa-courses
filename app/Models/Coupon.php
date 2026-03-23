<?php

namespace App\Models;

use Database\Factories\CouponFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    /** @use HasFactory<CouponFactory> */
    use HasFactory;

    protected $fillable = [
        'course_id',
        'code',
        'discount',
        'expiry_date',
    ];

    /**
     * @param  Builder<Coupon>  $query
     * @return Builder<Coupon>
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->whereNull('expiry_date')
                ->orWhere('expiry_date', '>', now());
        });
    }

    /**
     * @return BelongsTo<Course, $this>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
        ];
    }
}
