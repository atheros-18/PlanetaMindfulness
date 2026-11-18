@extends('layouts.app')
@section('title', 'Mi camino · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/mi-camino.css') }}">
@endpush
@section('content')
@php use App\Models\Setting; @endphp
<main>
    <section class="hero">
        @if ($foto = Setting::get('camino_foto'))
            <div class="photo"><img src="{{ asset($foto) }}" alt="Paloma Cano"></div>
        @endif
        <div class="intro">
            <div class="eyebrow">Conóceme</div>
            <h1>{{ Setting::get('camino_titulo', 'Mi camino') }}</h1>
            <p>{{ Setting::get('camino_intro') }}</p>
        </div>
    </section>
    <article class="content">{!! Setting::rich(Setting::get('camino_cuerpo')) !!}</article>
</main>
@endsection
