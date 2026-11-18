@php
    $cfg = [
        'horarios'   => ['inicio',     'home',  '1920 × 600'],
        'talleres'   => ['talleres',   'small', '1920 × 320'],
        'carteles'   => ['carteles',   'small', '1920 × 320'],
        'asociacion' => ['asociacion', 'small', '1920 × 320'],
        'online'     => ['online',     'small', '1920 × 320'],
        'mi-camino'  => ['camino',     'small', '1920 × 320'],
    ][Route::currentRouteName()] ?? null;
@endphp
@if ($cfg)
    @php [$bk, $size, $px] = $cfg; $img = \App\Models\Setting::get('banner_'.$bk); @endphp
    @if ($img)
        <div class="banner banner--{{ $size }}"><img src="{{ asset($img) }}" alt=""></div>
    @elseif (app()->isLocal())
        {{-- Hueco reservado: solo se ve en desarrollo hasta que se suba el banner desde el panel --}}
        <div class="banner banner--{{ $size }} banner-ph"><span>Aquí irá el banner · {{ $px }} px</span></div>
    @endif
@endif
