<?php

namespace App\Http\Controllers;

use App\Actions\EnrollmentAction;
use App\Models\Course;
use App\Services\CheckoutService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function checkout(Course $course): RedirectResponse|Redirector
    {
        if ($course->price > 0) {
            $session = CheckoutService::createCheckoutSession(
                $course,
                route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
                route('checkout.cancel')
            );
        }

        return redirect()->away($session->url ?? route('home'));
    }

    public function success(Request $request): View
    {
        /** @var string */
        $apiKey = config('services.stripe.secret');

        Stripe::setApiKey($apiKey);

        try {
            $sessionId = $request->string('session_id');

            /** @var Session $session */
            $session = Session::retrieve($sessionId);

            $courseId = $session->metadata['course_id'] ?? null;

            if (! $courseId) {
                throw new NotFoundHttpException('Course metadata missing.');
            }

            /** @var Course $course */
            $course = Course::findOrFail($courseId);

            (new EnrollmentAction)
                ->handle(
                    $course,
                    auth()->user() ?? throw new AuthenticationException,
                    $session
                );

            return view('welcome');

        } catch (ApiErrorException $e) {
            throw new NotFoundHttpException('Information not found.', $e);
        }
    }

    public function cancel(): void
    {
        //
    }
}
