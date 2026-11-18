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
    <script>
        (function () {
            try { if (localStorage.getItem('pm-theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark'); } catch (e) {}
        })();
    </script>
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
        ['/', 'Inicio', request()->is('/')],
        ['/calendario', 'Calendario', request()->is('calendario')],
        ['/talleres', 'Talleres y retiros', request()->is('talleres')],
        ['/carteles', 'Carteles', request()->is('carteles')],
        ['/asociacion', 'Asociación', request()->is('asociacion')],
        ['/online', 'Online', request()->is('online')],
        ['/mi-camino', 'Mi camino', request()->is('mi-camino')],
    ];
@endphp
<div class="sitenav" role="navigation" aria-label="Principal">
    <a class="sitenav-logo" href="{{ url('/') }}" aria-label="Planeta Mindfulness · Inicio">
        <img class="logo-light" src="{{ asset('img/logo.png') }}" alt="Planeta Mindfulness">
        <img class="logo-dark" src="{{ asset('img/logo-claro.png') }}" alt="" aria-hidden="true">
    </a>
    <div class="sitenav-links" id="sitenav-links">
        @foreach ($menu as [$href, $label, $on])
            <a href="{{ url($href) }}" @class(['on' => $on]) @if($on) aria-current="page" @endif>{{ $label }}</a>
        @endforeach
    </div>
    <span class="sitenav-end"><button type="button" class="theme-toggle" id="theme-toggle" aria-pressed="false" aria-label="Activar modo oscuro" title="Modo claro / oscuro"><svg class="i-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 14.5A8.5 8.5 0 0 1 9.5 4a8.5 8.5 0 1 0 10.5 10.5z"/></svg><svg class="i-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2.5v2.2M12 19.3v2.2M2.5 12h2.2M19.3 12h2.2M5.3 5.3l1.6 1.6M17.1 17.1l1.6 1.6M18.7 5.3l-1.6 1.6M6.9 17.1l-1.6 1.6"/></svg></button><button type="button" class="sitenav-toggle" aria-expanded="false" aria-controls="sitenav-links" aria-label="Abrir el menú"><span class="bars" aria-hidden="true"></span><span class="lbl">Menú</span></button></span>
</div>

@include('partials.banner')

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
<script>
(function () {
    var nav = document.querySelector('.sitenav'), btn = nav.querySelector('.sitenav-toggle');
    function set(open) {
        nav.classList.toggle('open', open);
        btn.setAttribute('aria-expanded', open);
        btn.setAttribute('aria-label', open ? 'Cerrar el menú' : 'Abrir el menú');
        btn.querySelector('.lbl').textContent = open ? 'Cerrar' : 'Menú';
    }
    btn.addEventListener('click', function (e) { e.stopPropagation(); set(!nav.classList.contains('open')); });
    document.addEventListener('click', function (e) { if (!nav.contains(e.target)) set(false); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') set(false); });
    window.addEventListener('resize', function () { if (innerWidth > 900) set(false); });
    nav.querySelectorAll('.sitenav-links a').forEach(function (a) { a.addEventListener('click', function () { set(false); }); });
})();
</script>
<script>
(function () {
    var root = document.documentElement, btn = document.getElementById('theme-toggle');
    var meta = document.querySelector('meta[name="theme-color"]');
    function sync() {
        var dark = root.getAttribute('data-theme') === 'dark';
        btn.setAttribute('aria-pressed', dark);
        btn.setAttribute('aria-label', dark ? 'Activar modo claro' : 'Activar modo oscuro');
        if (meta) meta.setAttribute('content', dark ? '#16111c' : '#5b2d7a');
    }
    btn.addEventListener('click', function () {
        var dark = root.getAttribute('data-theme') !== 'dark';
        root.classList.add('theme-anim');
        if (dark) root.setAttribute('data-theme', 'dark'); else root.removeAttribute('data-theme');
        try { localStorage.setItem('pm-theme', dark ? 'dark' : 'light'); } catch (e) {}
        sync();
        setTimeout(function () { root.classList.remove('theme-anim'); }, 450);
    });
    sync();
})();
</script>
@stack('scripts')
</body>
</html>
