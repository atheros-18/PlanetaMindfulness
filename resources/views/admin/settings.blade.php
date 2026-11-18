@extends('admin.layout')
@section('title', 'Ajustes')
@section('content')
<div class="adm-head"><h1>Ajustes</h1></div>
<form class="adm-form" method="POST" action="{{ route('admin.settings.save') }}" enctype="multipart/form-data">
    @csrf
    @foreach ($groups as $title => $fields)
        <fieldset class="adm-group">
            <legend>{{ $title }}</legend>
            @foreach ($fields as $f)
                @include('admin._field', ['f' => $f, 'value' => \App\Models\Setting::get($f['name']), 'ctrl' => $ctrl])
            @endforeach
        </fieldset>
    @endforeach
    <div class="adm-formbar"><button class="adm-btn primary" type="submit">Guardar ajustes</button></div>
</form>
@endsection
