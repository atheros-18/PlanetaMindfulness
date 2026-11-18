<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    protected $guarded = [];

    public const KINDS = [
        'taller' => 'Taller',
        'retiro' => 'Próximo retiro',
        'retiro_pasado' => 'Retiro ya vivido',
    ];

    private static function monthName(Carbon $d): string
    {
        return ucfirst($d->locale('es')->translatedFormat('F'));
    }

    /** Meses para elegir en el panel: 2 atrás y 14 adelante. */
    public static function monthOptions(): array
    {
        $out = [];
        $d = Carbon::now()->startOfMonth()->subMonths(2);
        for ($i = 0; $i < 17; $i++, $d->addMonth()) {
            $out[$d->format('Y-m')] = self::monthName($d).' '.$d->format('Y');
        }

        return $out;
    }

    /** Pestañas de meses de la web: desde el mes actual, $n meses. */
    public static function monthTabs(int $n): array
    {
        $tabs = [];
        $d = Carbon::now()->startOfMonth();
        for ($i = 0; $i < $n; $i++, $d->addMonth()) {
            $name = self::monthName($d);
            $tabs[] = ['key' => $d->format('Y-m'), 'name' => $name, 'label' => $name.' '.$d->format('Y')];
        }

        return $tabs;
    }

    public static function ofKind(string $kind)
    {
        return static::where('kind', $kind)->orderBy('month')->orderBy('sort')->orderBy('id')->get();
    }

    /** Datos listos para el JavaScript de las páginas. */
    public static function data(string $kind, bool $onlyWithImage = true): array
    {
        return self::ofKind($kind)
            ->filter(fn ($p) => ! $onlyWithImage || $p->image)
            ->map(fn ($p) => [
                'month' => $p->month,
                'date' => $p->date_text,
                'title' => $p->title,
                'place' => $p->place,
                'src' => $p->image ? asset($p->image) : null,
            ])->values()->all();
    }
}
