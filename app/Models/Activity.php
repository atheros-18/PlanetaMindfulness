<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    /** Párrafos de la descripción (separados por una línea en blanco). */
    public function paragraphs(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\n\s*\n/', (string) $this->description))));
    }
}
