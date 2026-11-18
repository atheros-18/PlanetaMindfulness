@extends('admin.layout')
@section('title', 'Inicio')
@section('content')
<h1>¿Qué quieres editar?</h1>
<div class="adm-cards">
    @foreach ($resources as $r)
        <a class="adm-card" href="{{ route('admin.index', $r['key']) }}">
            <b>{{ $r['label'] }}</b>
            <span>{{ $r['help'] }}</span>
            <em>{{ $r['count'] }} {{ $r['count'] === 1 ? 'elemento' : 'elementos' }}</em>
        </a>
    @endforeach
    <a class="adm-card" href="{{ route('admin.settings') }}">
        <b>Ajustes</b>
        <span>Redes sociales del pie de página y texto de «Mi camino».</span>
    </a>
</div>
@endsection
