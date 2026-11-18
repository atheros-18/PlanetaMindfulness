@extends('layouts.app')
@section('title', 'Talleres y retiros · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/carteles.css') }}">
@endpush
@section('content')
<main class="pg-carteles">
    <div class="hero">
        <div class="eyebrow">Experiencias para sentir y compartir</div>
        <h1>Talleres y retiros</h1>
        <p>Un tiempo para ti, para el movimiento, la atención plena y el encuentro.</p>
    </div>

    <section>
        <div class="eyebrow">Calendario de actividades</div>
        <h2>Talleres del mes</h2>
        <p>Elige un mes y desliza los carteles hacia la izquierda para descubrir los talleres.</p>
        <div class="months">
            @foreach ($tabs as $i => $tab)
                <button type="button" @class(['active' => $i === 0]) onclick="showMonth(this,'mes-{{ $i }}')">{{ $tab['label'] }}</button>
            @endforeach
        </div>
        @foreach ($tabs as $i => $tab)
            @php $posters = $byMonth[$tab['key']] ?? collect(); @endphp
            <div class="month-panel" id="mes-{{ $i }}" @if ($i) hidden @endif>
                @if ($posters->isEmpty())
                    <div class="empty">Próximamente, talleres de {{ mb_strtolower($tab['name']) }}.</div>
                @else
                    <div class="carousel" id="slides-{{ $i }}">
                        @foreach ($posters as $p)
                            <article class="slide">
                                @if ($p->image)<img src="{{ asset($p->image) }}" alt="Cartel: {{ $p->title }}">@endif
                                <div class="details">
                                    <strong>{{ $p->title }}</strong>
                                    <p>{{ collect([$p->date_text, $p->place])->filter()->implode(' · ') }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="controls">
                        <span class="tag">Desliza con el dedo para ver los carteles</span>
                        <div>
                            <button type="button" class="arrow" onclick="move(-1,'slides-{{ $i }}')" aria-label="Anterior">‹</button>
                            <button type="button" class="arrow" onclick="move(1,'slides-{{ $i }}')" aria-label="Siguiente">›</button>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </section>

    @if ($proximos->isNotEmpty())
    <section>
        <div class="eyebrow">Próximas experiencias</div>
        <h2>Próximos retiros</h2>
        @foreach ($proximos as $r)
            <div class="retreat">
                @if ($r->image)
                    <div class="visual" style="padding:0"><img src="{{ asset($r->image) }}" alt="Cartel: {{ $r->title }}" style="width:100%;height:100%;object-fit:cover"></div>
                @else
                    <div class="visual">{{ $r->title }}@if ($r->place)<br>{{ $r->place }}@endif</div>
                @endif
                <div class="copy">
                    @if ($r->date_text)<div class="tag">{{ $r->date_text }}</div>@endif
                    <h3>{{ $r->title }}</h3>
                    @if ($r->place)<p>{{ $r->place }}</p>@endif
                    @if ($r->description)<p>{{ $r->description }}</p>@endif
                </div>
            </div>
        @endforeach
    </section>
    @endif

    @if ($pasados->isNotEmpty())
    <section>
        <div class="eyebrow">Nuestra historia compartida</div>
        <h2>Retiros que hemos compartido</h2>
        <p>Momentos que permanecen, experiencias que nos acompañan.</p>
        <div class="past">
            @foreach ($pasados as $r)
                <article>
                    @if ($r->date_text)<div class="tag">{{ $r->date_text }}</div>@endif
                    <h3>{{ $r->title }}</h3>
                    @if ($r->place)<p>{{ $r->place }}</p>@endif
                    @if ($r->image)<img src="{{ asset($r->image) }}" alt="Cartel: {{ $r->title }}" style="width:100%;border-radius:8px">@endif
                </article>
            @endforeach
        </div>
    </section>
    @endif
</main>
@endsection

@push('scripts')
<script>
// Las flechas solo se muestran si los carteles del mes no caben (más de 4 en escritorio)
function updateControls(){document.querySelectorAll('.month-panel:not([hidden])').forEach(function(p){var c=p.querySelector('.carousel'),ctl=p.querySelector('.controls');if(!c||!ctl)return;ctl.hidden=!(c.scrollWidth>c.clientWidth+4);})}
function showMonth(btn,id){document.querySelectorAll('.months button').forEach(x=>x.classList.remove('active'));btn.classList.add('active');document.querySelectorAll('.month-panel').forEach(p=>p.hidden=p.id!==id);updateControls()}
function move(dir,id){const c=document.getElementById(id),s=c.querySelector('.slide');c.scrollBy({left:dir*((s?s.getBoundingClientRect().width:260)+14),behavior:'smooth'})}
addEventListener('resize',updateControls);addEventListener('load',updateControls);
if('ResizeObserver' in window){var ro=new ResizeObserver(updateControls);document.querySelectorAll('.carousel').forEach(function(c){ro.observe(c)})}
updateControls();
</script>
@endpush
