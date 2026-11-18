@extends('layouts.app')
@section('title', 'Calendario · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/calendario.css') }}">
@endpush
@section('content')
@php
    $dows = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
    $dayNames = ['', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    $kindLabel = ['clase' => 'Clase', 'taller' => 'Taller', 'retiro' => 'Retiro', 'otro' => 'Evento'];
@endphp
<main class="cal-wrap">
    <div class="cal-head">
        <div>
            <div class="eyebrow">Clases, talleres y retiros</div>
            <h1 class="cal-title">{{ $monthLabel }}</h1>
        </div>
        <div class="cal-nav">
            <a class="link" href="{{ url('/calendario?mes='.$prev) }}" aria-label="Mes anterior">‹ Anterior</a>
            @unless ($isCurrent)<a class="link" href="{{ url('/calendario') }}">Hoy</a>@endunless
            <a class="link" href="{{ url('/calendario?mes='.$next) }}" aria-label="Mes siguiente">Siguiente ›</a>
        </div>
    </div>

    <div class="cal-legend" aria-label="Leyenda">
        <span><i class="k-clase"></i>Clase</span>
        <span><i class="k-taller"></i>Taller</span>
        <span><i class="k-retiro"></i>Retiro</span>
        <span><i class="k-cerrado"></i>Sin clases</span>
    </div>

    <div class="cal-grid">
        @foreach ($dows as $dow)<div class="cal-dow">{{ $dow }}</div>@endforeach

        @foreach ($days as $day)
            @php $d = $day['date']; @endphp
            <div @class(['cal-day', 'ghost' => ! $day['inMonth'], 'has' => count($day['items']), 'today' => $day['today'], 'closed' => $day['closed'], 'empty' => $day['inMonth'] && ! count($day['items']) && ! $day['closed']])>
                @if ($day['inMonth'])
                    <span class="cal-num">{{ $d->day }}</span>
                    <span class="cal-wd">{{ $dayNames[$d->dayOfWeekIso] }}</span>
                    @if ($day['closed'])<div class="cal-closed">{{ $day['closed'] }}</div>@endif
                    @foreach ($day['items'] as $it)
                        @if ($it['activity_id'])
                            <button type="button" class="cal-item k-{{ $it['kind'] }}" aria-haspopup="dialog"
                                    onclick="document.getElementById('m-{{ $it['activity_id'] }}').showModal()">
                        @else
                            <div class="cal-item k-{{ $it['kind'] }}">
                        @endif
                            <strong>{{ $it['title'] }}</strong>
                            @if ($it['time'])<small>{{ $it['time'] }}</small>@endif
                            @if ($it['span'])<small>{{ $it['span'] }}</small>@endif
                            @if ($it['place'])<small>{{ $it['place'] }}</small>@endif
                        @if ($it['activity_id'])</button>@else</div>@endif
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>

    @if ($total === 0)
        <p class="cal-none">Este mes no hay actividades publicadas todavía.</p>
    @endif

    <p class="cal-note">Las clases semanales se repiten de septiembre a junio. Pulsa una actividad con ficha para ver su información.</p>
</main>

@foreach ($activities as $a)
    <dialog id="m-{{ $a->id }}" aria-label="{{ $a->title }}" onclick="if(event.target===this)this.close()">
        <button type="button" class="close" aria-label="Cerrar" onclick="this.closest('dialog').close()">×</button>
        @if ($a->image)<img class="modalimg" src="{{ asset($a->image) }}" alt="Imagen de {{ $a->title }}">@endif
        <div class="content">
            @if ($a->subtitle)<div class="subtitle">{{ $a->subtitle }}</div>@endif
            <h3>{{ $a->title }}</h3>
            @foreach ($a->paragraphs() as $p)<p>{{ $p }}</p>@endforeach
        </div>
    </dialog>
@endforeach
@endsection
