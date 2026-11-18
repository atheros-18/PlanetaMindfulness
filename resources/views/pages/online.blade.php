@extends('layouts.app')
@section('title', 'Online · Planeta Mindfulness')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/online.css') }}">
@endpush
@section('content')
@verbatim
<main><div class="hero"><div class="eyebrow">Prácticas y aprendizaje a tu ritmo</div><h1>Online</h1><p>Recursos para profundizar en mindfulness, enseñar y meditar desde donde estés.</p></div><section id="online"><div class="eyebrow">Desde donde estés</div><h2>Online</h2><p>Recursos para enseñar, aprender y practicar la atención plena.</p><div class="online-grid"><article class="online-card"><div class="online-visual">◌</div><div class="online-body"><div class="tag">Para docentes</div><h3>Recursos de meditación para profesores</h3><p>Materiales y propuestas para enriquecer tus clases.</p><p>Próximamente</p></div></article><article class="online-card"><div class="online-visual">36 semanas</div><div class="online-body"><div class="tag">Programa completo</div><h3>Curso de mindfulness</h3><p>Un recorrido de 36 semanas para incorporar la atención plena a la vida cotidiana.</p><p>Próximamente</p></div></article><article class="online-card"><img src="/img/d5d138612b.jpg" alt="Fotografía original de Paloma Cano en Insight Timer"><div class="online-body"><div class="tag">Meditaciones gratuitas</div><h3>Insight Timer</h3><p>Escucha mis meditaciones gratuitas en la app Insight Timer, a tu propio ritmo.</p><a class="online-link" href="https://insighttimer.com/" target="_blank" rel="noopener">Ir a Insight Timer</a></div></article></div><p style="font-size:12px">Enlace provisional a la aplicación; pendiente de añadir la dirección directa de tu perfil.</p></section></main>
@endverbatim
@endsection

@push('scripts')
<script src="{{ asset('js/online.js') }}"></script>
@endpush
