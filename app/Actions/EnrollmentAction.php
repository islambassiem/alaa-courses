<?php

declare(strict_types=1);

namespace App\Actions;

use App\Events\UserEnrolled;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Stripe\Checkout\Session;

final readonly class EnrollmentAction
{
    /**
     * Execute the action.
     */
    public function handle(Course $course, User $user, ?Session $session): Enrollment
    {
        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'session_id' => $session->id ?? null,
            'payment_intent' => $session->payment_intent ?? null,
            'payment_status' => $session->payment_status ?? null,
            'amount_total' => $session->amount_total ?? null,
        ]);

        event(new UserEnrolled($course, $user));

        return $enrollment;
    }
}
