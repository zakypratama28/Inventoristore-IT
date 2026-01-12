@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="bi bi-chat-dots-fill text-primary me-2"></i>
                Customer Support
            </h2>
            <p class="text-muted mb-0">Kami siap membantu Anda 24/7. Tanyakan apapun tentang produk atau pesanan Anda!</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-lg" style="height: 600px; display: flex; flex-direction: column;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-headset me-2"></i>IGGStore Support Chat
                    </h5>
                    <small class="opacity-75">Tim support kami akan membantu Anda</small>
                </div>

                <div class="card-body flex-grow-1 overflow-auto" id="chatMessages" style="background: #f8f9fa;">
                    @if($chats->isEmpty())
                        <div class="text-center text-muted mt-5">
                            <i class="bi bi-headset display-1 text-primary opacity-25"></i>
                            <h5 class="mt-4 fw-bold">Selamat Datang di IGGStore Support!</h5>
                            <p class="mt-2">Mulai percakapan dengan kami untuk mendapatkan bantuan.<br>Kami siap membantu Anda dengan cepat dan profesional.</p>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-check-circle me-1"></i>Respon cepat
                                    <span class="mx-2">|</span>
                                    <i class="bi bi-shield-check me-1"></i>Aman & terpercaya
                                </small>
                            </div>
                        </div>
                    @else
                        @foreach($chats as $chat)
                            <div class="mb-3 {{ $chat->sender_type === 'user' ? 'text-end' : 'text-start' }}">
                                <div class="d-inline-block" style="max-width: 70%;">
                                    <div class="p-3 rounded {{ $chat->sender_type === 'user' ? 'bg-primary text-white' : 'bg-white' }}" style="box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                        <p class="mb-1">{{ $chat->message }}</p>
                                        <small class="opacity-75">
                                            {{ $chat->created_at->format('H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="card-footer bg-white border-top py-3">
                    <form id="chatForm" action="{{ route('chat.store') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" 
                                   name="message" 
                                   id="messageInput"
                                   class="form-control form-control-lg" 
                                   placeholder="Ketik pesan Anda di sini..."
                                   required>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-scroll to bottom
const chatMessages = document.getElementById('chatMessages');
if(chatMessages) {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Handle form submit via AJAX
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageInput = document.getElementById('messageInput');
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Add message to UI
            const messageHTML = `
                <div class="mb-3 text-end">
                    <div class="d-inline-block" style="max-width: 70%;">
                        <div class="p-3 rounded bg-primary text-white" style="box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            <p class="mb-1">${data.chat.message}</p>
                            <small class="opacity-75">Just now</small>
                        </div>
                    </div>
                </div>
            `;
            
            const noMessages = chatMessages.querySelector('.text-muted');
            if(noMessages) {
                noMessages.remove();
            }
            
            chatMessages.insertAdjacentHTML('beforeend', messageHTML);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            messageInput.value = '';
        }
    })
    .catch(error => console.error('Error:', error));
});

// Auto-refresh messages every 5 seconds
setInterval(() => {
    fetch('{{ route("chat.messages") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(chats => {
        // Update chat messages if needed
        // Implementation depends on your requirements
    });
}, 5000);
</script>
@endpush
@endsection
