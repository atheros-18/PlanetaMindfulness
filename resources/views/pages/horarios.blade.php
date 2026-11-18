@extends('layouts.app')
@section('title', 'Clases y horarios · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/horarios.css') }}">
@endpush
@section('content')
<main>
    <h1>Clases y horarios</h1>
    <p class="intro">Pulsa la <b>i</b> junto a cada actividad para descubrirla.</p>

    <div class="groups">
    @foreach ($groups as $sede => $days)
        <section class="group">
            <h2>{{ $sede }}</h2>
            @foreach ($days as $dayLabel => $slots)
                @php [$dayName, $dayPlace] = array_pad(explode(' · ', $dayLabel, 2), 2, null); @endphp
                <div class="day-block">
                    <div class="place day-label"><strong>{{ $dayName }}</strong>@if ($dayPlace) · {{ $dayPlace }}@endif</div>
                    @foreach ($slots as $slot)
                        <div class="entry">
                            <div>
                                <strong>{{ $slot->title }}</strong>
                                @if ($slot->time)<div class="when">{{ $slot->time }}</div>@endif
                            </div>
                            @if ($slot->activity_id)
                                <button type="button" class="info" aria-haspopup="dialog"
                                        aria-label="Información de {{ $slot->title }}"
                                        onclick="document.getElementById('m-{{ $slot->activity_id }}').showModal()">i</button>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </section>
    @endforeach
    </div>

    <div class="end">
        @if ($wa = \App\Models\Setting::get('social_whatsapp'))
            <a class="link" href="{{ $wa }}" target="_blank" rel="noopener noreferrer">WhatsApp · Consultas e inscripciones</a>
        @endif
        <p><a class="link" href="{{ url('/talleres') }}">Talleres y retiros →</a></p>
    </div>
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
