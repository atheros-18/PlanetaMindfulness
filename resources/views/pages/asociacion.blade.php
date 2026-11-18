@extends('layouts.app')
@section('title', 'Asociación · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/asociacion.css') }}">
@endpush
@section('content')
@verbatim
<main><section aria-label="Paloma y Cruz" class="founders"><img alt="Paloma y Cruz compartiendo un momento de movimiento y alegría" src="/img/e0eb63f703.jpg"/><div><div class="eyebrow">Las personas detrás de la asociación</div><h2>Paloma y Cruz, almas mater de la asociación Planeta Mindfulness</h2><p>Compartimos la ilusión de crear espacios de encuentro donde la música, el movimiento y la atención plena nos ayuden a conectar con nosotras mismas y con los demás.</p></div></section><div class="eyebrow">Asociación · Alcobendas</div><h1>Actividades por meses</h1><p class="intro">Encuentros para compartir, cuidarnos y crecer. Talleres de septiembre a junio y domingos de ocio saludable.</p><div class="months" id="monthsBar"></div><section class="panel"><div class="topline"><h2 id="monthTitle"></h2><span class="counter" id="counter"></span></div><div class="postersrow"><button type="button" class="arrow" id="prev" aria-label="Carteles anteriores" hidden>‹</button><div class="pviewport" id="pview"><div class="ptrack" id="ptrack"></div></div><button type="button" class="arrow" id="next" aria-label="Carteles siguientes" hidden>›</button></div><div class="hint">Toca un cartel para ampliarlo</div></section>
<section class="section"><div class="eyebrow">Lo que hacemos</div><h2>Compartir bienestar</h2><div class="cards"><article class="card"><h3>Con el Ayuntamiento</h3><p>Talleres gratuitos en colaboración con el Ayuntamiento de Alcobendas.</p><div class="dates"><b>Marzo</b> · Día de la Mujer<br/><b>Abril</b> · Semana de la Salud<br/><b>Mayo–junio</b> · Semana del Mayor</div></article><article class="card"><span class="eyebrow">Primer sábado de junio</span><h3>Retiro Urbano · Nuestro cierre de curso</h3><p>Cada año, el primer sábado de junio, organizamos nuestro Retiro Urbano, una jornada muy especial para compartir, disfrutar y cerrar el curso junt@s.</p><p>A lo largo del día disfrutamos de diferentes actividades como Biodanza, danzas africanas, yoga, meditación, coaching...</p><p>Cada persona trae algo de comida para compartir y convertimos este encuentro en una celebración de la convivencia, el movimiento, la alegría y todo lo vivido durante el curso.</p></article><article class="card"><span class="eyebrow">Pausas para reencontrarnos</span><h3>Retiros en la Naturaleza</h3><p>A lo largo de estos años hemos organizado diferentes retiros en plena naturaleza, creando espacios para alejarnos por unos días del ritmo cotidiano y dedicar tiempo a nosotr@s mism@s.</p><p>Cada retiro gira en torno a un tema concreto que exploramos a través de la Biodanza, el movimiento consciente, la meditación y otras propuestas de crecimiento personal.</p><p>Pero los retiros son también convivencia: compartir las comidas, conversar, disfrutar de la naturaleza, encontrarnos con otras personas y vivir experiencias que nos permiten conocernos un poquito mejor.</p><p>Una oportunidad para salir de la rutina, conectar con lo que sentimos y regresar a nuestra vida cotidiana con una mirada renovada.</p></article></div></section>
@endverbatim
<section class="section" id="retiros"><div class="eyebrow">Experiencias para compartir</div><h2>Retiros</h2><div class="miniRetreats">
@foreach ([['Próximo retiro', $proximo], ['Retiro ya vivido', $pasado]] as [$tag, $r])
@if ($r)
<article class="retreat">@if ($r->image)<img alt="Cartel {{ $r->title }}" src="{{ asset($r->image) }}" title="Ampliar cartel">@endif<div><div class="tag">{{ $tag }}</div><h3>{{ $r->title }}</h3><small>{!! collect([$r->date_text, $r->place])->filter()->map(fn ($x) => e($x))->implode('<br/>') !!}</small></div></article>
@endif
@endforeach
</div><p style="font-size:13px;color:#728477;margin-top:12px">Más información y programación en la pestaña «Talleres y retiros».</p></section>
@verbatim<section aria-label="Talleres y contacto" class="final-cta"><span class="eyebrow">Seguimos compartiendo</span><h2>¿Te apetece participar?</h2><p>Descubre los próximos talleres, encuentros y retiros, o escríbenos para saber más.</p><div class="cta-buttons"><a class="cta primary" href="/talleres">  Talleres puntuales</a><a class="cta secondary" href="https://wa.me/34647752638?text=Hola%2C%20quiero%20informaci%C3%B3n%20sobre%20Planeta%20Mindfulness" rel="noopener noreferrer" target="_blank">◉   WhatsApp</a></div></section></main><div aria-label="Cartel ampliado" class="lightbox" id="lightbox" role="dialog"><button aria-label="Cerrar" class="close" id="close">×</button><img alt="Cartel ampliado" id="large"/></div>
@endverbatim
@endsection

@push('scripts')
<script>window.PM = @json($pm);</script>
<script src="{{ asset('js/asociacion.js') }}"></script>
@endpush
