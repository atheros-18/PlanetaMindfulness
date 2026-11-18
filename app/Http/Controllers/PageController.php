<?php

namespace App\Http\Controllers;

use App\Models\OnlineCard;
use App\Models\Poster;
use App\Models\ScheduleSlot;

class PageController extends Controller
{
    public function horarios()
    {
        $slots = ScheduleSlot::with('activity')->orderBy('sort')->orderBy('id')->get();
        $groups = $slots->groupBy('sede')->map(fn ($g) => $g->groupBy('day_label'));
        $activities = $slots->pluck('activity')->filter()->unique('id');

        return view('pages.horarios', compact('groups', 'activities'));
    }

    public function talleres()
    {
        return view('pages.talleres', ['pm' => [
            'months' => Poster::monthTabs(8),
            'workshops' => Poster::data('taller'),
            'retreats' => Poster::data('retiro'),
            'past' => Poster::data('retiro_pasado'),
        ]]);
    }

    public function carteles()
    {
        $tabs = Poster::monthTabs(3);
        $byMonth = Poster::ofKind('taller')->groupBy('month');

        return view('pages.carteles', [
            'tabs' => $tabs,
            'byMonth' => $byMonth,
            'proximos' => Poster::ofKind('retiro'),
            'pasados' => Poster::ofKind('retiro_pasado'),
        ]);
    }

    public function asociacion()
    {
        $items = Poster::ofKind('taller')->filter(fn ($p) => $p->image)->groupBy('month');
        $months = collect(Poster::monthTabs(12))
            ->filter(fn ($t) => $items->has($t['key']))
            ->map(fn ($t) => $t + ['items' => $items[$t['key']]->map(fn ($p) => [
                'name' => trim(($p->date_text ? $p->date_text.' · ' : '').$p->title),
                'src' => asset($p->image),
            ])->values()->all()])
            ->values()->all();

        return view('pages.asociacion', [
            'pm' => ['months' => $months],
            'proximo' => Poster::ofKind('retiro')->first(fn ($p) => $p->image) ?? Poster::ofKind('retiro')->first(),
            'pasado' => Poster::ofKind('retiro_pasado')->first(fn ($p) => $p->image) ?? Poster::ofKind('retiro_pasado')->first(),
        ]);
    }

    public function online()
    {
        return view('pages.online', ['cards' => OnlineCard::orderBy('sort')->orderBy('id')->get()]);
    }

    public function camino()
    {
        return view('pages.mi-camino');
    }
}
