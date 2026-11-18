<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Planeta Mindfulness')</title>
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
    <div class="site-footer-grid">
        <div class="site-footer-brand">
            <a href="{{ url('/') }}"><img class="site-footer-logo" src="{{ asset('img/logo-claro.png') }}" alt="Planeta Mindfulness"></a>
            <p>Tu bienestar a través de la música, el movimiento y la atención plena.</p>
        </div>
        <div>
            <h4>Explora</h4>
            <ul>
                @foreach ($menu as [$href, $label])
                    <li><a href="{{ url($href) }}">{{ $label }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4>Síguenos</h4>
            <ul class="social">
                @foreach (config('social') as $name => $item)
                    @if (!empty($item['url']))
                        <li><a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer">{{ $item['label'] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="site-footer-bottom">
        <span>© {{ date('Y') }} Planeta Mindfulness</span>
        <span class="ver">{{ $version }}</span>
    </div>
</div>
@stack('scripts')
</body>
</html>
