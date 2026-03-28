<?php

use App\Enums\ConversationStatusEnum;
use App\Enums\MessageSenderTypeEnum;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $selectedConversation = null;

    public $messages = [];

    public $message = '';

    public $search = '';

    public $showUnreadOnly = true;

    protected $listeners = ['conversationSelected' => 'selectConversation'];

    public function mount()
    {
        $this->loadConversations();
    }

    public function updatedSearch()
    {
        $this->loadConversations();
    }

    #[Computed()]
    public function conversations()
    {
        if (! $this->showUnreadOnly) {
            $query = ChatConversation::with(['user', 'lastMessage'])
                ->withCount(['messages as unread_count' => function ($q) {
                    $q->where('sender_type', MessageSenderTypeEnum::USER)
                        ->where('is_read', false);
                }])
                ->orderBy('last_message_at', 'desc');

            // Apply Unread Filter
            if ($this->showUnreadOnly) {
                $query->whereHas('messages', function ($q) {
                    $q->where('sender_type', MessageSenderTypeEnum::USER)
                        ->where('is_read', false);
                });
            }

            // Apply Search Filter
            if ($this->search) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                });
            }

            return $query->get();
        }

        return collect();
    }

    public function loadConversations()
    {
        $query = ChatConversation::with(['user', 'lastMessage'])
            ->withCount(['messages as unread_count' => function ($q) {
                $q->where('sender_type', MessageSenderTypeEnum::USER)
                    ->where('is_read', false);
            }])
            ->orderBy('last_message_at', 'desc');

        if ($this->showUnreadOnly) {
            $query->whereHas('messages', function ($q) {
                $q->where('sender_type', MessageSenderTypeEnum::USER)
                    ->where('is_read', false);
            });
        }

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }

        $this->conversations = $query->get();
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversation = ChatConversation::with('user')->find($conversationId);
        $this->loadMessages();
        $this->markMessagesAsRead();
    }

    public function loadMessages()
    {
        if (! $this->selectedConversation) {
            return;
        }

        $this->messages = ChatMessage::where('conversation_id', $this->selectedConversation->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();

        $this->dispatch('scrollToBottom');
    }

    public function markMessagesAsRead()
    {
        if (! $this->selectedConversation) {
            return;
        }

        ChatMessage::where('conversation_id', $this->selectedConversation->id)
            ->where('sender_type', MessageSenderTypeEnum::USER)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->loadConversations();
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        if (! $this->selectedConversation) {
            return;
        }

        ChatMessage::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => Auth::id(),
            'sender_type' => MessageSenderTypeEnum::ADMIN,
            'message' => $this->message,
            'is_read' => false,
        ]);

        $this->selectedConversation->update([
            'last_message_at' => now(),
        ]);

        $this->message = '';
        $this->loadMessages();
        $this->loadConversations();

        // Optionally notify user via email or push notification
    }

    public function closeConversation()
    {
        if (! $this->selectedConversation) {
            return;
        }

        $this->selectedConversation->update(['status' => ConversationStatusEnum::CLOSED]);
        $this->selectedConversation = null;
        $this->messages = [];
        $this->loadConversations();
    }
};
