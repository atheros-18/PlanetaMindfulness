<?php

/*
 | Definición del panel de administración (/palomacano1).
 | Cada recurso se edita con un formulario generado a partir de 'fields'.
 | Tipos: text, textarea, number, select, image.
 */
return [
    'resources' => [
        'calendario' => [
            'model' => App\Models\CalendarEvent::class,
            'label' => 'Calendario del mes',
            'singular' => 'evento',
            'help' => 'Talleres, retiros, clases puntuales y días sin clases con fecha concreta. Se ven en la pestaña «Calendario». Las clases semanales salen solas desde «Horario semanal».',
            'order' => ['date', 'id'],
            'columns' => ['date', 'end_date', 'kind', 'title', 'time'],
            'fields' => [
                ['name' => 'date', 'label' => 'Fecha (o primer día)', 'type' => 'date', 'rules' => 'required|date'],
                ['name' => 'end_date', 'label' => 'Último día (solo si dura varios días)', 'type' => 'date', 'rules' => 'nullable|date|after_or_equal:date', 'help' => 'Para un retiro de 13 a 15, pon 13 arriba y 15 aquí.'],
                ['name' => 'kind', 'label' => 'Tipo', 'type' => 'select', 'options' => 'event_kinds', 'rules' => 'required|in:taller,retiro,clase,cerrado,otro', 'help' => '«Día cerrado» oculta las clases semanales de ese día y muestra el título (por ejemplo, Festivo).'],
                ['name' => 'title', 'label' => 'Título', 'type' => 'text', 'rules' => 'required|max:200'],
                ['name' => 'time', 'label' => 'Horario', 'type' => 'text', 'rules' => 'nullable|max:60', 'help' => 'Ej.: 10:30 – 13:30'],
                ['name' => 'place', 'label' => 'Lugar', 'type' => 'text', 'rules' => 'nullable|max:200'],
                ['name' => 'activity_id', 'label' => 'Ficha de información (opcional)', 'type' => 'select', 'options' => 'activities', 'rules' => 'nullable|exists:activities,id', 'help' => 'Si eliges una, al pulsar el evento se abre su ficha.'],
            ],
        ],
        'horarios' => [
            'model' => App\Models\ScheduleSlot::class,
            'label' => 'Horario semanal',
            'singular' => 'clase',
            'help' => 'Las clases fijas de cada semana. Salen en «Clases y horarios» y se repiten solas cada semana en el Calendario.',
            'order' => ['sede', 'sort', 'id'],
            'columns' => ['sede', 'day_label', 'title', 'time'],
            'fields' => [
                ['name' => 'sede', 'label' => 'Población / sede', 'type' => 'text', 'rules' => 'required|max:120', 'help' => 'Ej.: Colmenar Viejo. Las clases con la misma sede se agrupan juntas.'],
                ['name' => 'day_label', 'label' => 'Día y lugar', 'type' => 'text', 'rules' => 'required|max:160', 'help' => 'Ej.: Martes · Sala Vive Yoga'],
                ['name' => 'title', 'label' => 'Nombre de la clase', 'type' => 'text', 'rules' => 'required|max:200'],
                ['name' => 'time', 'label' => 'Horario', 'type' => 'text', 'rules' => 'nullable|max:60', 'help' => 'Ej.: 18:00 – 19:00'],
                ['name' => 'activity_id', 'label' => 'Ficha de información (la «i»)', 'type' => 'select', 'options' => 'activities', 'rules' => 'nullable|exists:activities,id'],
                ['name' => 'in_calendar', 'label' => '¿Repetir cada semana en el Calendario?', 'type' => 'checkbox', 'rules' => 'nullable|boolean', 'help' => 'Desmárcalo si la clase no es semanal (por ejemplo, un sábado al mes) y añade sus fechas en «Calendario del mes».'],
                ['name' => 'sort', 'label' => 'Orden', 'type' => 'number', 'rules' => 'nullable|integer', 'help' => 'Número más bajo = aparece antes.'],
            ],
        ],
        'actividades' => [
            'model' => App\Models\Activity::class,
            'label' => 'Fichas de actividad',
            'singular' => 'ficha',
            'help' => 'El texto y la imagen que se ven al pulsar la «i» de una clase.',
            'order' => ['title'],
            'columns' => ['image', 'title', 'subtitle'],
            'fields' => [
                ['name' => 'title', 'label' => 'Título', 'type' => 'text', 'rules' => 'required|max:200'],
                ['name' => 'subtitle', 'label' => 'Subtítulo', 'type' => 'text', 'rules' => 'nullable|max:200'],
                ['name' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'rows' => 9, 'rules' => 'nullable', 'help' => 'Separa los párrafos con una línea en blanco.'],
                ['name' => 'image', 'label' => 'Imagen', 'type' => 'image'],
            ],
        ],
        'carteles' => [
            'model' => App\Models\Poster::class,
            'label' => 'Carteles (talleres y retiros)',
            'singular' => 'cartel',
            'help' => 'Sube carteles nuevos o edita los que ya hay. Aparecen en «Talleres y retiros», «Carteles» y «Asociación».',
            'order' => ['kind', 'month', 'sort', 'id'],
            'columns' => ['image', 'kind', 'month', 'date_text', 'title'],
            'fields' => [
                ['name' => 'kind', 'label' => 'Tipo', 'type' => 'select', 'options' => 'kinds', 'rules' => 'required|in:taller,retiro,retiro_pasado'],
                ['name' => 'month', 'label' => 'Mes (solo talleres y retiros próximos)', 'type' => 'select', 'options' => 'months', 'rules' => 'nullable|max:7'],
                ['name' => 'date_text', 'label' => 'Fecha', 'type' => 'text', 'rules' => 'nullable|max:120', 'help' => 'Ej.: 22 de noviembre'],
                ['name' => 'title', 'label' => 'Título', 'type' => 'text', 'rules' => 'required|max:200'],
                ['name' => 'place', 'label' => 'Lugar', 'type' => 'text', 'rules' => 'nullable|max:200'],
                ['name' => 'image', 'label' => 'Imagen del cartel', 'type' => 'image'],
                ['name' => 'sort', 'label' => 'Orden', 'type' => 'number', 'rules' => 'nullable|integer'],
            ],
        ],
        'online' => [
            'model' => App\Models\OnlineCard::class,
            'label' => 'Pestaña Online',
            'singular' => 'tarjeta',
            'help' => 'Las tarjetas de la página «Online».',
            'order' => ['sort', 'id'],
            'columns' => ['image', 'tag', 'title'],
            'fields' => [
                ['name' => 'tag', 'label' => 'Etiqueta pequeña', 'type' => 'text', 'rules' => 'nullable|max:100'],
                ['name' => 'title', 'label' => 'Título', 'type' => 'text', 'rules' => 'required|max:200'],
                ['name' => 'body', 'label' => 'Texto', 'type' => 'textarea', 'rows' => 4, 'rules' => 'nullable'],
                ['name' => 'image', 'label' => 'Imagen', 'type' => 'image'],
                ['name' => 'visual', 'label' => 'Texto grande (si no hay imagen)', 'type' => 'text', 'rules' => 'nullable|max:40'],
                ['name' => 'link_url', 'label' => 'Enlace (dirección web)', 'type' => 'text', 'rules' => 'nullable|url|max:300'],
                ['name' => 'link_text', 'label' => 'Texto del botón', 'type' => 'text', 'rules' => 'nullable|max:80'],
                ['name' => 'sort', 'label' => 'Orden', 'type' => 'number', 'rules' => 'nullable|integer'],
            ],
        ],
    ],

    'settings' => [
        'Redes sociales (pie de página)' => [
            ['name' => 'social_whatsapp', 'label' => 'WhatsApp', 'type' => 'text', 'rules' => 'nullable|url|max:300', 'help' => 'Ej.: https://wa.me/34647752638'],
            ['name' => 'social_instagram', 'label' => 'Instagram', 'type' => 'text', 'rules' => 'nullable|url|max:300'],
            ['name' => 'social_facebook', 'label' => 'Facebook', 'type' => 'text', 'rules' => 'nullable|url|max:300'],
            ['name' => 'social_youtube', 'label' => 'YouTube', 'type' => 'text', 'rules' => 'nullable|url|max:300'],
            ['name' => 'social_insight', 'label' => 'Insight Timer', 'type' => 'text', 'rules' => 'nullable|url|max:300'],
        ],
        'Banners de cada página' => [
            ['name' => 'banner_inicio', 'label' => 'Inicio (Clases y horarios) · banner grande', 'type' => 'image', 'help' => 'Medida: 1920 × 600 px (proporción 16:5). Deja lo importante en el centro: en móvil se recortan los lados.'],
            ['name' => 'banner_calendario', 'label' => 'Calendario · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1900 × 300 px (proporción 19:3).'],
            ['name' => 'banner_talleres', 'label' => 'Talleres y retiros · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1900 × 300 px (proporción 19:3).'],
            ['name' => 'banner_carteles', 'label' => 'Carteles · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1900 × 300 px (proporción 19:3).'],
            ['name' => 'banner_asociacion', 'label' => 'Asociación · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1900 × 300 px (proporción 19:3).'],
            ['name' => 'banner_online', 'label' => 'Online · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1900 × 300 px (proporción 19:3).'],
            ['name' => 'banner_camino', 'label' => 'Mi camino · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1900 × 300 px (proporción 19:3).'],
        ],
        'Página «Mi camino»' => [
            ['name' => 'camino_foto', 'label' => 'Foto', 'type' => 'image'],
            ['name' => 'camino_titulo', 'label' => 'Título', 'type' => 'text', 'rules' => 'nullable|max:120'],
            ['name' => 'camino_intro', 'label' => 'Texto de presentación', 'type' => 'textarea', 'rows' => 4, 'rules' => 'nullable'],
            ['name' => 'camino_cuerpo', 'label' => 'Texto principal', 'type' => 'textarea', 'rows' => 18, 'rules' => 'nullable',
                'help' => 'Párrafos separados por una línea en blanco. **negrita**, *cursiva*. Una línea con --- pone un separador.'],
        ],
    ],
];
