@php $name = $f['name']; $val = old($name, $value ?? null); @endphp
<div class="adm-field">
    <label for="f-{{ $name }}">{{ $f['label'] }}</label>
    @switch($f['type'])
        @case('textarea')
            <textarea id="f-{{ $name }}" name="{{ $name }}" rows="{{ $f['rows'] ?? 5 }}">{{ $val }}</textarea>
            @break
        @case('number')
            <input id="f-{{ $name }}" type="number" name="{{ $name }}" value="{{ $val }}">
            @break
        @case('select')
            <select id="f-{{ $name }}" name="{{ $name }}">
                @foreach ($ctrl->options($f['options']) as $k => $label)
                    <option value="{{ $k }}" @selected((string) $val === (string) $k)>{{ $label }}</option>
                @endforeach
            </select>
            @break
        @case('image')
            @if ($value ?? null)
                <div class="adm-current">
                    <img src="{{ asset($value) }}" alt="Imagen actual">
                    <label class="adm-check"><input type="checkbox" name="remove_{{ $name }}" value="1"> Quitar imagen</label>
                </div>
            @endif
            <input id="f-{{ $name }}" type="file" name="{{ $name }}" accept="image/png,image/jpeg,image/webp,image/gif">
            <small>{{ ($value ?? null) ? 'Elige un archivo solo si quieres cambiar la imagen.' : 'JPG, PNG, WebP o GIF, máximo 8 MB.' }}</small>
            @break
        @default
            <input id="f-{{ $name }}" type="text" name="{{ $name }}" value="{{ $val }}">
    @endswitch
    @if (!empty($f['help']) && $f['type'] !== 'image')<small>{{ $f['help'] }}</small>@endif
</div>
