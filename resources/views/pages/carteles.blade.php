@extends('layouts.app')
@section('title', 'Talleres y retiros · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/carteles.css') }}">
@endpush
@section('content')
@verbatim
<main><div class="hero"><div class="eyebrow">Experiencias para sentir y compartir</div><h1>Talleres y retiros</h1><p>Un tiempo para ti, para el movimiento, la atención plena y el encuentro.</p></div>
<section><div class="eyebrow">Calendario de actividades</div><h2>Talleres del mes</h2><p>Elige un mes y desliza los carteles hacia la izquierda para descubrir los talleres.</p><div class="months"><button class="active" onclick="showMonth(this,'nov')">Noviembre 2026</button><button onclick="showMonth(this,'dic')">Diciembre 2026</button><button onclick="showMonth(this,'ene')">Enero 2027</button></div>
<div id="nov"><div class="carousel" id="slides"><article class="slide"><img src="/img/00b9b61c99.jpg" alt="Cartel original Biodanza Vulnerabilidad"><div class="details"><strong>Vulnerabilidad</strong><p>21 de noviembre · Sala Kaykal · Colmenar Viejo</p></div></article><article class="slide"><img src="/img/dc5a22198f.jpg" alt="Cartel original La gratitud"><div class="details"><strong>La gratitud</strong><p>27 de noviembre · Vive Yoga · Colmenar Viejo</p></div></article></div><div class="controls"><span class="tag">Desliza con el dedo para ver los carteles</span><div><button class="arrow" onclick="move(-1)" aria-label="Anterior">‹</button> <button class="arrow" onclick="move(1)" aria-label="Siguiente">›</button></div></div></div>
<div id="dic" class="empty" hidden>Próximamente, talleres de diciembre.</div><div id="ene" class="empty" hidden>Próximamente, talleres de enero.</div></section>
<section><div class="eyebrow">Próximas experiencias</div><h2>Próximos retiros</h2><div class="retreat"><div class="visual">Verano para sentir<br>Málaga</div><div class="copy"><div class="tag">29 de julio – 1 de agosto de 2027</div><h3>Verano para sentir</h3><p>Cuatro días de mindfulness, biodanza, movimiento consciente, descanso y naturaleza.</p><p>Programa y alojamiento por confirmar.</p></div></div></section>
<section><div class="eyebrow">Nuestra historia compartida</div><h2>Retiros que hemos compartido</h2><p>Momentos que permanecen, experiencias que nos acompañan.</p><div class="past"><article><div class="tag">31 de julio – 2 de agosto</div><h3>Yoga, meditación y biodanza</h3><p>Manzanares el Real y Mataelpino · Entorno Kadampa</p><p>Espacio reservado para fotos y vídeos del retiro.</p></article><article><div class="tag">13–15 de noviembre de 2026</div><h3>El placer de soltar</h3><p>El Pagano · Arenas de San Pedro, Ávila</p><p>Espacio reservado para fotos y vídeos del retiro.</p></article></div></section></main>
@endverbatim
@endsection

@push('scripts')
<script src="{{ asset('js/carteles.js') }}"></script>
@endpush
