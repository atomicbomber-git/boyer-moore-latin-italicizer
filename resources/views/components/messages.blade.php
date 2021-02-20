@foreach(session(\App\Support\SessionHelper::MESSAGES_KEY) ?? [] as $message)
    <div
            class="my-3 alert alert-{{ $message['state'] ?? \App\Support\MessageState::STATE_INFO }} alert-dismissible fade show"
    >
        @switch($message['state'] ?? 'primary')
            @case(\App\Support\MessageState::STATE_INFO)
            <i class="fas fa-info-circle"></i>
            @break
            @case(\App\Support\MessageState::STATE_SUCCESS)
            <i class="fas fa-check-circle"></i>
            @break
            @case(\App\Support\MessageState::STATE_WARNING)
            <i class="fas fa-exclamation-circle"></i>
            @break
            @case(\App\Support\MessageState::STATE_DANGER)
            <i class="fas fa-times-circle"></i>
            @break
        @endswitch
        {{ $message['content'] ?? 'Default message content.' }}
        <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
        ></button>
    </div>
@endforeach
