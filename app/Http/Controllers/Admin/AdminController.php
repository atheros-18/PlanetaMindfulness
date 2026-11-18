<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Poster;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*
 | TODO (antes de pasar a producción): proteger todo este panel con contraseña.
 | Ahora mismo /palomacano1 es accesible sin autenticación.
 */
class AdminController extends Controller
{
    private function resource(string $key): array
    {
        $c = config("admin.resources.$key");
        abort_unless($c, 404);
        $c['key'] = $key;

        return $c;
    }

    public function options(string $name): array
    {
        return match ($name) {
            'activities' => ['' => '— Sin ficha —'] + Activity::orderBy('title')->pluck('title', 'id')->all(),
            'kinds' => Poster::KINDS,
            'event_kinds' => \App\Models\CalendarEvent::KINDS,
            'months' => ['' => '— Sin mes —'] + Poster::monthOptions(),
            default => [],
        };
    }

    public function dashboard()
    {
        $resources = collect(config('admin.resources'))
            ->map(fn ($c, $k) => $c + ['key' => $k, 'count' => $c['model']::count()]);

        return view('admin.dashboard', compact('resources'));
    }

    public function index(string $key)
    {
        $c = $this->resource($key);
        $q = $c['model']::query();
        foreach ($c['order'] as $col) {
            $q->orderBy($col);
        }

        return view('admin.index', ['c' => $c, 'items' => $q->get(), 'ctrl' => $this]);
    }

    public function create(string $key)
    {
        $c = $this->resource($key);
        $item = new $c['model'];
        // Valor de orden sugerido: al final de la lista
        if (\Illuminate\Support\Facades\Schema::hasColumn($item->getTable(), 'sort')) {
            $item->sort = ((int) $c['model']::max('sort')) + 10;
        }

        return view('admin.form', ['c' => $c, 'item' => $item, 'ctrl' => $this]);
    }

    public function store(Request $request, string $key)
    {
        $c = $this->resource($key);
        $c['model']::create($this->payload($request, $c['fields']));

        return redirect()->route('admin.index', $key)->with('ok', 'Guardado correctamente.');
    }

    public function edit(string $key, int $id)
    {
        $c = $this->resource($key);

        return view('admin.form', ['c' => $c, 'item' => $c['model']::findOrFail($id), 'ctrl' => $this]);
    }

    public function update(Request $request, string $key, int $id)
    {
        $c = $this->resource($key);
        $c['model']::findOrFail($id)->update($this->payload($request, $c['fields']));

        return redirect()->route('admin.index', $key)->with('ok', 'Cambios guardados.');
    }

    public function destroy(string $key, int $id)
    {
        $c = $this->resource($key);
        $c['model']::findOrFail($id)->delete();

        return redirect()->route('admin.index', $key)->with('ok', 'Eliminado.');
    }

    public function settings()
    {
        return view('admin.settings', ['groups' => config('admin.settings'), 'ctrl' => $this]);
    }

    public function saveSettings(Request $request)
    {
        $fields = collect(config('admin.settings'))->flatten(1)->all();
        $data = $this->payload($request, $fields);
        foreach ($fields as $f) {
            if (array_key_exists($f['name'], $data)) {
                Setting::put($f['name'], $data[$f['name']]);
            }
        }

        return redirect()->route('admin.settings')->with('ok', 'Ajustes guardados.');
    }

    /** Valida y prepara los datos del formulario, subiendo las imágenes. */
    private function payload(Request $request, array $fields): array
    {
        $rules = [];
        foreach ($fields as $f) {
            $rules[$f['name']] = $f['rules'] ?? ($f['type'] === 'image'
                ? 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:8192'
                : 'nullable');
        }
        $data = $request->validate($rules);

        foreach ($fields as $f) {
            $name = $f['name'];
            if ($f['type'] === 'image') {
                unset($data[$name]);
                if ($request->hasFile($name)) {
                    $file = $request->file($name);
                    $fileName = Str::random(14).'.'.$file->extension();
                    $file->move(public_path('uploads'), $fileName);
                    $data[$name] = 'uploads/'.$fileName;
                } elseif ($request->boolean('remove_'.$name)) {
                    $data[$name] = null;
                }
            } elseif ($f['type'] === 'checkbox') {
                $data[$name] = $request->boolean($name);
            } elseif ($f['type'] === 'number') {
                $data[$name] = (int) ($data[$name] ?? 0);
            }
        }

        return $data;
    }
}
