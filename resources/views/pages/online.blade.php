@extends('layouts.app')
@section('title', 'Online · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/online.css') }}">
@endpush
@section('content')
<main>
    <div class="hero">
        <div class="eyebrow">Prácticas y aprendizaje a tu ritmo</div>
        <h1>Online</h1>
        <p>Recursos para profundizar en mindfulness, enseñar y meditar desde donde estés.</p>
    </div>
    <section id="online">
        <div class="eyebrow">Desde donde estés</div>
        <h2>Online</h2>
        <p>Recursos para enseñar, aprender y practicar la atención plena.</p>
        <div class="online-grid">
            @foreach ($cards as $c)
                <article class="online-card">
                    @if ($c->image)
                        <img src="{{ asset($c->image) }}" alt="{{ $c->title }}">
                    @else
                        <div class="online-visual">{{ $c->visual ?: 'Online' }}</div>
                    @endif
                    <div class="online-body">
                        @if ($c->tag)<div class="tag">{{ $c->tag }}</div>@endif
                        <h3>{{ $c->title }}</h3>
                        @if ($c->body)<p>{{ $c->body }}</p>@endif
                        @if ($c->link_url)
                            <a class="online-link" href="{{ $c->link_url }}" target="_blank" rel="noopener noreferrer">{{ $c->link_text ?: 'Ver más' }}</a>
                        @else
                            <p>Próximamente</p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</main>
@endsection
