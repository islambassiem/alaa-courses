<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => $this->stats(),
            'recent_enrollments' => $this->recentEnrollments(),
            'latest_reviews' => $this->latestReviews(),
            'unread_support' => $this->unreadSupport(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function stats(): array
    {
        return [
            'revenue' => $this->revenue(),
            'students' => $this->students(),
            'avg_rating' => $this->rating(),
            'active_chats' => $this->chats(),
        ];
    }

    /**
     * @return Collection<int, Enrollment>
     */
    private function recentEnrollments(): Collection
    {
        return Enrollment::query()
            ->with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();
    }

    /**
     * @return Collection<int, Review>
     */
    private function latestReviews(): Collection
    {
        return Review::query()
            ->with(['user', 'course'])
            ->whereNotNull('comment')
            ->latest()
            ->take(4)
            ->get();
    }

    /**
     * @return Collection<int, ChatConversation>
     */
    private function unreadSupport(): Collection
    {
        return ChatConversation::query()
            ->with('user')
            ->whereHas('messages', fn ($q) => $q->where('is_read', false)->where('sender_type', 'user'))
            ->take(3)
            ->get();
    }

    private function revenue(): float
    {
        return Enrollment::where('payment_status', 'paid')->sum('amount_total') / 100;
    }

    private function students(): int
    {
        return Enrollment::distinct('user_id')->count();
    }

    private function rating(): float
    {
        return (float) Review::avg('rating');
    }

    private function chats(): int
    {
        return ChatConversation::where('status', 'active')->count();
    }
}
