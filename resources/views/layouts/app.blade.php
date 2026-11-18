<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Planeta Mindfulness')</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    @stack('styles')
</head>
<body>
<div class="sitenav" role="navigation" aria-label="Principal">
    <a class="sitenav-brand" href="{{ url('/') }}">Planeta Mindfulness</a>
    <div class="sitenav-links">
        <a href="{{ url('/') }}" @class(['on' => request()->is('/')])>Clases y horarios</a>
        <a href="{{ url('/talleres') }}" @class(['on' => request()->is('talleres')])>Talleres y retiros</a>
        <a href="{{ url('/carteles') }}" @class(['on' => request()->is('carteles')])>Carteles</a>
        <a href="{{ url('/asociacion') }}" @class(['on' => request()->is('asociacion')])>Asociación</a>
        <a href="{{ url('/online') }}" @class(['on' => request()->is('online')])>Online</a>
        <a href="{{ url('/mi-camino') }}" @class(['on' => request()->is('mi-camino')])>Mi camino</a>
    </div>
</div>
@yield('content')
@stack('scripts')
</body>
</html>
