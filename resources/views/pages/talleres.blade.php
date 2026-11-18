@extends('layouts.app')
@section('title', 'Talleres y retiros · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/talleres.css') }}">
@endpush
@section('content')
@verbatim
<main><header><div class="eyebrow">ASOCIACIÓN · PLANETA MINDFULNESS</div><h1>Talleres y retiros</h1><p>Encuentros para conectar contigo, con el movimiento y con los demás.</p></header><section><h2>Talleres</h2><p>Selecciona un mes. Si hay varios talleres, desliza para ver todos sus carteles.</p><div class="months" id="months"></div><div class="bar"><h3 id="monthTitle"></h3><div class="nav"><button id="wprev" aria-label="Taller anterior">‹</button><button id="wnext" aria-label="Taller siguiente">›</button></div></div><div class="viewport" id="wview"><div class="track" id="wtrack"></div></div><p class="hint">Desliza los carteles · Toca uno para ampliarlo</p></section><div class="divider"></div><section><h2>Próximos retiros</h2><p>Próximos encuentros para compartir, conectar y disfrutar.</p><div class="bar"><h3>El arte de soltar · 13–15 de noviembre de 2026</h3><div class="nav"><button id="rprev" aria-label="Retiro anterior">‹</button><button id="rnext" aria-label="Retiro siguiente">›</button></div></div><div class="viewport" id="rview"><div class="track" id="rtrack"></div></div><p class="hint">Desliza los carteles · Toca uno para ampliarlo</p></section><div class="divider"></div><section><h2>Retiros ya vividos</h2><p>Momentos compartidos que forman parte de nuestro camino.</p><div class="bar"><h3>Mataelpino y Manzanares el Real</h3><div class="nav"><button id="pprev" aria-label="Retiro vivido anterior">‹</button><button id="pnext" aria-label="Retiro vivido siguiente">›</button></div></div><div class="viewport" id="pview"><div class="track" id="ptrack"></div></div><p class="hint">Desliza los carteles · Toca uno para ampliarlo</p></section><footer>Planeta Mindfulness · Tu bienestar a través de la música, el movimiento y la atención plena</footer></main><dialog id="viewer"><button id="close">Cerrar ×</button><img id="large" alt="Cartel ampliado"></dialog>
@endverbatim
@endsection

@push('scripts')
<script src="{{ asset('js/talleres.js') }}"></script>
@endpush
