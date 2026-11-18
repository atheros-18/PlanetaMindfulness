@extends('admin.layout')
@section('title', ($item->exists ? 'Editar ' : 'Añadir ').$c['singular'])
@section('content')
<div class="adm-head">
    <h1>{{ $item->exists ? 'Editar' : 'Añadir' }} {{ $c['singular'] }}</h1>
    <a class="adm-btn" href="{{ route('admin.index', $c['key']) }}">← Volver</a>
</div>
<form class="adm-form" method="POST" enctype="multipart/form-data"
      action="{{ $item->exists ? route('admin.update', [$c['key'], $item->id]) : route('admin.store', $c['key']) }}">
    @csrf
    @if ($item->exists) @method('PUT') @endif
    @foreach ($c['fields'] as $f)
        @include('admin._field', ['f' => $f, 'value' => $item->{$f['name']}, 'ctrl' => $ctrl])
    @endforeach
    <div class="adm-formbar">
        <button class="adm-btn primary" type="submit">Guardar</button>
        <a class="adm-btn" href="{{ route('admin.index', $c['key']) }}">Cancelar</a>
    </div>
</form>
@endsection
