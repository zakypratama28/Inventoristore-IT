@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>

            <article class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <h1 class="display-4 fw-bold mb-4">{{ $page->title }}</h1>
                    
                    <div class="content">
                        {!! nl2br(e($page->content)) !!}
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>

<style>
    .content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--color-text);
    }

    .content h2 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .content h3 {
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }

    .content p {
        margin-bottom: 1rem;
    }

    .content ul, .content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }

    .content li {
        margin-bottom: 0.5rem;
    }
</style>
@endsection
