<?php

namespace App\Models;

use Database\Factories\ChatMessageFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    /** @use HasFactory<ChatMessageFactory> */
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'sender_type',
        'message',
        'is_read',
    ];

    /**
     * @return BelongsTo<ChatConversation, $this>
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function isFromAdmin(): bool
    {
        return $this->sender_type === 'admin';
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    #[Scope]
    protected function unread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    #[Scope]
    protected function fromAdmin(Builder $query): Builder
    {
        return $query->where('sender_type', 'admin');
    }

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }
}
