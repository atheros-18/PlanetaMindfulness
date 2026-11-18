<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Planeta Mindfulness')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#5b2d7a">
    {{-- Tipografías: Quicksand (menú y botones), Lora (textos), Fraunces (títulos) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,600;1,9..144,300;1,9..144,400&family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
@php
    $menu = [
        ['/', 'Clases y horarios', request()->is('/')],
        ['/talleres', 'Talleres y retiros', request()->is('talleres')],
        ['/carteles', 'Carteles', request()->is('carteles')],
        ['/asociacion', 'Asociación', request()->is('asociacion')],
        ['/online', 'Online', request()->is('online')],
        ['/mi-camino', 'Mi camino', request()->is('mi-camino')],
    ];
@endphp
<div class="sitenav" role="navigation" aria-label="Principal">
    <a class="sitenav-logo" href="{{ url('/') }}" aria-label="Planeta Mindfulness · Inicio">
        <img src="{{ asset('img/logo.png') }}" alt="Planeta Mindfulness">
    </a>
    <div class="sitenav-links">
        @foreach ($menu as [$href, $label, $on])
            <a href="{{ url($href) }}" @class(['on' => $on]) @if($on) aria-current="page" @endif>{{ $label }}</a>
        @endforeach
    </div>
    <span class="sitenav-end"></span>
</div>

@yield('content')

<div class="site-footer" role="contentinfo">
    <div class="site-footer-row">
        <a class="site-footer-logo" href="{{ url('/') }}" aria-label="Inicio"><img src="{{ asset('img/logo-claro.png') }}" alt="Planeta Mindfulness"></a>
        <div class="site-footer-links">
            @foreach ($menu as [$href, $label])
                <a href="{{ url($href) }}">{{ $label }}</a>
            @endforeach
        </div>
        <ul class="social">
            @foreach (\App\Models\Setting::socials() as $label => $url)
                <li><a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $label }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="site-footer-bottom">
        <span>© {{ date('Y') }} Planeta Mindfulness · Tu bienestar a través de la música, el movimiento y la atención plena</span>
        <span class="ver">{{ $version }}</span>
    </div>
</div>
@stack('scripts')
</body>
</html>
