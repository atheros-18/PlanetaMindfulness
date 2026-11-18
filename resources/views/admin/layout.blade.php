<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <script>
        (function () {
            try { if (localStorage.getItem('pm-theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark'); } catch (e) {}
        })();
    </script>
    <title>@yield('title', 'Panel') · Planeta Mindfulness</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Lora:ital,wght@0,400;0,600;1,400&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="adm-warn">Panel sin contraseña · modo desarrollo. Hay que protegerlo antes de publicar la web.</div>
<header class="adm-top">
    <a class="adm-brand" href="{{ route('admin.home') }}"><img class="logo-light" src="{{ asset('img/logo.png') }}" alt=""><img class="logo-dark" src="{{ asset('img/logo-claro.png') }}" alt=""><span>Panel de Planeta Mindfulness</span></a>
    <nav>
        @foreach (config('admin.resources') as $k => $r)
            <a href="{{ route('admin.index', $k) }}" @class(['on' => request()->is("palomacano1/$k*")])>{{ $r['label'] }}</a>
        @endforeach
        <a href="{{ route('admin.settings') }}" @class(['on' => request()->is('palomacano1/ajustes')])>Ajustes</a>
        <a href="{{ url('/') }}" target="_blank" class="out">Ver la web ↗</a>
    </nav>
    <button type="button" class="adm-theme" id="adm-theme" aria-pressed="false" aria-label="Activar modo oscuro" title="Modo claro / oscuro"><svg class="i-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 14.5A8.5 8.5 0 0 1 9.5 4a8.5 8.5 0 1 0 10.5 10.5z"/></svg><svg class="i-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2.5v2.2M12 19.3v2.2M2.5 12h2.2M19.3 12h2.2M5.3 5.3l1.6 1.6M17.1 17.1l1.6 1.6M18.7 5.3l-1.6 1.6M6.9 17.1l-1.6 1.6"/></svg></button>
</header>
<main class="adm-main">
    @if (session('ok'))<div class="adm-ok">{{ session('ok') }}</div>@endif
    @if ($errors->any())
        <div class="adm-err"><b>Revisa estos datos:</b><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
</main>
<script>
(function () {
    var root = document.documentElement, btn = document.getElementById('adm-theme');
    function sync() {
        var dark = root.getAttribute('data-theme') === 'dark';
        btn.setAttribute('aria-pressed', dark);
        btn.setAttribute('aria-label', dark ? 'Activar modo claro' : 'Activar modo oscuro');
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
</body>
</html>
