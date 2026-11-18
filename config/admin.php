<?php

/*
 | Definición del panel de administración (/palomacano1).
 | Cada recurso se edita con un formulario generado a partir de 'fields'.
 | Tipos: text, textarea, number, select, image.
 */
return [
    'resources' => [
        'horarios' => [
            'model' => App\Models\ScheduleSlot::class,
            'label' => 'Calendario de clases',
            'singular' => 'clase',
            'help' => 'Cada fila es una clase en el calendario de «Clases y horarios».',
            'order' => ['sede', 'sort', 'id'],
            'columns' => ['sede', 'day_label', 'title', 'time'],
            'fields' => [
                ['name' => 'sede', 'label' => 'Población / sede', 'type' => 'text', 'rules' => 'required|max:120', 'help' => 'Ej.: Colmenar Viejo. Las clases con la misma sede se agrupan juntas.'],
                ['name' => 'day_label', 'label' => 'Día y lugar', 'type' => 'text', 'rules' => 'required|max:160', 'help' => 'Ej.: Martes · Sala Vive Yoga'],
                ['name' => 'title', 'label' => 'Nombre de la clase', 'type' => 'text', 'rules' => 'required|max:200'],
                ['name' => 'time', 'label' => 'Horario', 'type' => 'text', 'rules' => 'nullable|max:60', 'help' => 'Ej.: 18:00 – 19:00'],
                ['name' => 'activity_id', 'label' => 'Ficha de información (la «i»)', 'type' => 'select', 'options' => 'activities', 'rules' => 'nullable|exists:activities,id'],
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
            ['name' => 'banner_talleres', 'label' => 'Talleres y retiros · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1920 × 320 px (proporción 6:1).'],
            ['name' => 'banner_carteles', 'label' => 'Carteles · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1920 × 320 px (proporción 6:1).'],
            ['name' => 'banner_asociacion', 'label' => 'Asociación · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1920 × 320 px (proporción 6:1).'],
            ['name' => 'banner_online', 'label' => 'Online · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1920 × 320 px (proporción 6:1).'],
            ['name' => 'banner_camino', 'label' => 'Mi camino · banner pequeño', 'type' => 'image', 'help' => 'Medida: 1920 × 320 px (proporción 6:1).'],
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
