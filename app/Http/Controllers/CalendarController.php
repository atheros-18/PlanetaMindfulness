<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CalendarEvent;
use App\Models\ScheduleSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CalendarController extends Controller
{
    /** Meses en los que se repiten las clases semanales (septiembre a junio). */
    private const COURSE_MONTHS = [9, 10, 11, 12, 1, 2, 3, 4, 5, 6];

    private const WEEKDAYS = ['lunes' => 1, 'martes' => 2, 'miercoles' => 3, 'jueves' => 4, 'viernes' => 5, 'sabado' => 6, 'domingo' => 7];

    public function index(Request $request)
    {
        $mes = (string) $request->query('mes', '');
        $month = preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $mes)
            ? Carbon::createFromFormat('!Y-m', $mes)
            : Carbon::now()->startOfMonth();

        $gridStart = $month->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd = $month->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $events = CalendarEvent::whereDate('date', '<=', $gridEnd)
            ->where(fn ($q) => $q->whereDate('end_date', '>=', $gridStart)
                ->orWhere(fn ($q2) => $q2->whereNull('end_date')->whereDate('date', '>=', $gridStart)))
            ->get();

        // Clases semanales: el día de la semana sale de la primera palabra de «Día y lugar»
        $slots = ScheduleSlot::where('in_calendar', true)->get()->map(function ($s) {
            $first = Str::of($s->day_label)->before(' ')->ascii()->lower()->toString();
            $s->weekday = self::WEEKDAYS[$first] ?? null;

            return $s;
        })->filter(fn ($s) => $s->weekday);

        $days = [];
        $total = 0;
        for ($d = $gridStart->copy(); $d <= $gridEnd; $d->addDay()) {
            $inMonth = $d->month === $month->month;
            $dayEvents = $events->filter(fn ($e) => $d->between(
                $e->date->copy()->startOfDay(),
                ($e->end_date ?? $e->date)->copy()->endOfDay()
            ));
            $closed = $dayEvents->firstWhere('kind', 'cerrado');
            $items = [];

            if ($inMonth && ! $closed) {
                if (in_array($d->month, self::COURSE_MONTHS)) {
                    foreach ($slots->where('weekday', $d->dayOfWeekIso) as $s) {
                        $items[] = ['kind' => 'clase', 'title' => $s->title, 'time' => $s->time, 'place' => $s->sede,
                            'activity_id' => $s->activity_id, 'span' => null];
                    }
                }
                foreach ($dayEvents->where('kind', '!=', 'cerrado') as $e) {
                    $span = null;
                    if ($e->end_date && ! $e->end_date->isSameDay($e->date)) {
                        $span = 'Día '.($e->date->diffInDays($d) + 1).' de '.($e->date->diffInDays($e->end_date) + 1);
                    }
                    $items[] = ['kind' => $e->kind, 'title' => $e->title, 'time' => $e->time, 'place' => $e->place,
                        'activity_id' => $e->activity_id, 'span' => $span];
                }
                usort($items, function ($a, $b) {
                    $ka = ($a['kind'] === 'retiro' ? '0' : '1').(preg_match('/\d{1,2}:\d{2}/', (string) $a['time'], $m) ? str_pad($m[0], 5, '0', STR_PAD_LEFT) : '99:99');
                    $kb = ($b['kind'] === 'retiro' ? '0' : '1').(preg_match('/\d{1,2}:\d{2}/', (string) $b['time'], $m) ? str_pad($m[0], 5, '0', STR_PAD_LEFT) : '99:99');

                    return $ka <=> $kb;
                });
                $total += count($items);
            }

            $days[] = [
                'date' => $d->copy(),
                'inMonth' => $inMonth,
                'items' => $items,
                'closed' => $inMonth && $closed ? $closed->title : null,
                'today' => $d->isToday(),
            ];
        }

        $ids = collect($days)->pluck('items')->flatten(1)->pluck('activity_id')->filter()->unique();

        return view('pages.calendario', [
            'days' => $days,
            'total' => $total,
            'monthLabel' => ucfirst($month->copy()->locale('es')->translatedFormat('F Y')),
            'prev' => $month->copy()->subMonth()->format('Y-m'),
            'next' => $month->copy()->addMonth()->format('Y-m'),
            'isCurrent' => $month->isSameMonth(Carbon::now()),
            'activities' => Activity::whereIn('id', $ids)->get(),
        ]);
    }
}
