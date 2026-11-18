@extends('admin.layout')
@section('title', $c['label'])
@section('content')
@php
    $fieldsByName = collect($c['fields'])->keyBy('name');
    $optCache = [];
@endphp
<div class="adm-head">
    <div>
        <h1>{{ $c['label'] }}</h1>
        <p class="adm-help">{{ $c['help'] }}</p>
    </div>
    <a class="adm-btn primary" href="{{ route('admin.create', $c['key']) }}">+ Añadir {{ $c['singular'] }}</a>
</div>

@if ($items->isEmpty())
    <p class="adm-empty">Todavía no hay nada aquí.</p>
@else
<div class="adm-tablewrap">
<table class="adm-table">
    <thead>
        <tr>
            @foreach ($c['columns'] as $col)<th>{{ $fieldsByName[$col]['label'] ?? $col }}</th>@endforeach
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($items as $item)
        <tr>
            @foreach ($c['columns'] as $col)
                @php $f = $fieldsByName[$col] ?? ['type' => 'text']; $v = $item->$col; @endphp
                <td data-label="{{ $f['label'] ?? $col }}">
                    @if ($f['type'] === 'image')
                        @if ($v)<img class="adm-thumb" src="{{ asset($v) }}" alt="">@else <span class="adm-dim">—</span>@endif
                    @elseif ($f['type'] === 'select')
                        @php $optCache[$f['options']] ??= $ctrl->options($f['options']); @endphp
                        {{ $optCache[$f['options']][$v] ?? ($v ?: '—') }}
                    @else
                        {{ \Illuminate\Support\Str::limit((string) $v, 70) ?: '—' }}
                    @endif
                </td>
            @endforeach
            <td class="adm-actions">
                <a class="adm-btn" href="{{ route('admin.edit', [$c['key'], $item->id]) }}">Editar</a>
                <form method="POST" action="{{ route('admin.destroy', [$c['key'], $item->id]) }}" onsubmit="return confirm('¿Eliminar este elemento? No se puede deshacer.')">
                    @csrf @method('DELETE')
                    <button class="adm-btn danger" type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@endif
@endsection
