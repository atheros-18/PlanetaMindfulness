@php
    $cfg = [
        'horarios'   => ['inicio',     'home',  '1920 × 600'],
        'calendario' => ['calendario', 'small', '1900 × 300'],
        'talleres'   => ['talleres',   'small', '1900 × 300'],
        'carteles'   => ['carteles',   'small', '1900 × 300'],
        'asociacion' => ['asociacion', 'small', '1900 × 300'],
        'online'     => ['online',     'small', '1900 × 300'],
        'mi-camino'  => ['camino',     'small', '1900 × 300'],
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
