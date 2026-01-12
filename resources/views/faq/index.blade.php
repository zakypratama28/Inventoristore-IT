@extends('layouts.app')

@section('content')
<div class="faq-page">
    {{-- Hero Section --}}
    <div class="bg-gradient-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-3">Pertanyaan Umum (FAQ)</h1>
                    <p class="lead mb-0">
                        Temukan jawaban atas pertanyaan yang paling sering diajukan mengenai layanan, produk, dan proses pemesanan kami.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQ Content --}}
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if($faqs->count() > 0)
                    <div class="accordion" id="faqAccordion">
                       @foreach($faqs as $index => $faq)
                            <div class="accordion-item mb-3 border-0 shadow-sm">
                                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }} fw-semibold" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $faq->id }}" 
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $faq->id }}">
                                        <i class="bi bi-question-circle me-2"></i>
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $faq->id }}" 
                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                     aria-labelledby="heading{{ $faq->id }}" 
                                     data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-question-circle text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 text-muted">Belum ada FAQ</h4>
                    </div>
                @endif

                {{-- Contact Section --}}
                <div class="mt-5 p-4 bg-light rounded-4 text-center">
                    <h5 class="fw-bold mb-3">Masih memiliki pertanyaan?</h5>
                    <p class="text-muted mb-4">
                        Jika Anda tidak menemukan jawaban yang Anda cari, silakan hubungi tim support kami.
                    </p>
                    <a href="{{ route('chat.index') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-chat-dots me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.accordion-button:not(.collapsed) {
    background-color: #667eea;
    color: white;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(102, 126, 234, 0.5);
}

.accordion-item {
    border-radius: 12px !important;
    overflow: hidden;
}

.accordion-button {
    border-radius: 12px !important;
}

.accordion-button:not(.collapsed) {
    border-bottom-left-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}
</style>
@endsection
