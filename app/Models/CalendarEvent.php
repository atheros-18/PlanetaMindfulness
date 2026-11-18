<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $guarded = [];

    protected $casts = ['date' => 'date', 'end_date' => 'date', 'in_calendar' => 'boolean'];

    public const KINDS = [
        'taller' => 'Taller',
        'retiro' => 'Retiro (puede durar varios días)',
        'clase' => 'Clase puntual',
        'cerrado' => 'Día cerrado / festivo (sin clases)',
        'otro' => 'Otro',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
