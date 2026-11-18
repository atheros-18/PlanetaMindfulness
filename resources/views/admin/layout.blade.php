<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
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
    <a class="adm-brand" href="{{ route('admin.home') }}"><img src="{{ asset('img/logo.png') }}" alt=""><span>Panel de Planeta Mindfulness</span></a>
    <nav>
        @foreach (config('admin.resources') as $k => $r)
            <a href="{{ route('admin.index', $k) }}" @class(['on' => request()->is("palomacano1/$k*")])>{{ $r['label'] }}</a>
        @endforeach
        <a href="{{ route('admin.settings') }}" @class(['on' => request()->is('palomacano1/ajustes')])>Ajustes</a>
        <a href="{{ url('/') }}" target="_blank" class="out">Ver la web ↗</a>
    </nav>
</header>
<main class="adm-main">
    @if (session('ok'))<div class="adm-ok">{{ session('ok') }}</div>@endif
    @if ($errors->any())
        <div class="adm-err"><b>Revisa estos datos:</b><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
</main>
</body>
</html>
