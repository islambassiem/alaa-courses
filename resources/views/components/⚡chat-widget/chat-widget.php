<?php

use App\Enums\MessageSenderTypeEnum;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $isOpen = false;

    public $message = '';

    public $messages = [];

    public $conversation = null;

    public $isTyping = false;

    protected $listeners = ['messageSent' => 'loadMessages'];

    public function mount()
    {
        $this->loadOrCreateConversation();
        $this->loadMessages();
    }

    #[Computed()]
    public function unreadMessagesCount()
    {
        $conversation = ChatConversation::where('user_id', Auth::id())->first();

        if (! $conversation) {
            return 0;
        }

        return ChatMessage::query()
            ->where('conversation_id', $conversation->id)
            ->where('sender_type', MessageSenderTypeEnum::ADMIN)
            ->where('is_read', 0)
            ->count();
    }

    public function loadOrCreateConversation()
    {
        if (! Auth::check()) {
            return;
        }

        $this->conversation = ChatConversation::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'status' => 'active',
                'last_message_at' => now(),
            ]
        );
    }

    public function loadMessages()
    {
        if (! $this->conversation) {
            return;
        }

        $this->messages = ChatMessage::where('conversation_id', $this->conversation->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();

        if ($this->isOpen) {
            $this->markAsRead();
        }

        $this->dispatch('scroll-to-bottom');
    }

    public function markAsRead()
    {
        ChatMessage::where('conversation_id', $this->conversation->id)
            ->where('sender_type', MessageSenderTypeEnum::ADMIN)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function sendMessage()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        if (! $this->conversation) {
            $this->loadOrCreateConversation();
        }

        ChatMessage::create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => Auth::id(),
            'sender_type' => MessageSenderTypeEnum::USER,
            'message' => $this->message,
            'is_read' => false,
        ]);

        $this->conversation->update([
            'last_message_at' => now(),
        ]);

        $this->message = '';
        $this->loadMessages();

        // Notify admin (you can implement this with events/notifications)
        // event(new NewChatMessage($this->conversation));
    }

    public function toggleChat()
    {
        $this->isOpen = ! $this->isOpen;

        if ($this->isOpen) {
            $this->markAsRead();
            $this->loadMessages();
            $this->dispatch('scroll-to-bottom');
        }
    }
};
