<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    private static ?array $all = null;

    public static function get(string $key, $default = null)
    {
        self::$all ??= self::pluck('value', 'key')->all();

        return self::$all[$key] ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        self::$all = null;
    }

    /** Redes sociales que tienen enlace: [etiqueta => url]. */
    public static function socials(): array
    {
        $map = [
            'social_whatsapp' => 'WhatsApp',
            'social_instagram' => 'Instagram',
            'social_facebook' => 'Facebook',
            'social_youtube' => 'YouTube',
            'social_insight' => 'Insight Timer',
        ];
        $out = [];
        foreach ($map as $key => $label) {
            if ($url = self::get($key)) {
                $out[$label] = $url;
            }
        }

        return $out;
    }

    /**
     * Texto sencillo a HTML: párrafos separados por línea en blanco,
     * **negrita**, *cursiva* y una línea con --- como separador.
     */
    public static function rich(?string $text): string
    {
        $html = '';
        foreach (preg_split('/\n\s*\n/', trim((string) $text)) as $block) {
            $block = trim($block);
            if ($block === '') {
                continue;
            }
            if ($block === '---') {
                $html .= '<hr class="separator">';

                continue;
            }
            $b = nl2br(e($block));
            $b = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $b);
            $b = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $b);
            $html .= '<p>'.$b.'</p>';
        }

        return $html;
    }
}
