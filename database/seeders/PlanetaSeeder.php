<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\OnlineCard;
use App\Models\Poster;
use App\Models\ScheduleSlot;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/** Contenido inicial migrado de los HTML originales. Solo se ejecuta si las tablas están vacías. */
class PlanetaSeeder extends Seeder
{
    public function run(): void
    {
        if (Activity::count() === 0) {
            $this->activities();
        }
        if (Poster::count() === 0) {
            $this->posters();
        }
        if (OnlineCard::count() === 0) {
            $this->online();
        }
        $this->settings();
    }

    private function activities(): void
    {
        $a = [];
        $mk = function (string $k, string $title, ?string $sub, string $desc, ?string $img) use (&$a) {
            $a[$k] = Activity::create(['title' => $title, 'subtitle' => $sub, 'description' => $desc, 'image' => $img ? "img/$img" : null]);
        };

        $mk('lab', 'Laboratorio de Biodanza', 'Coaching a través del movimiento',
            "Te propongo un recorrido de 36 sesiones para descubrirte y conocerte mejor a través del movimiento.\n\nExploraremos gestos y movimientos que, con el paso del tiempo, hemos dejado de utilizar, ampliando nuestro repertorio corporal y descubriendo nuevas posibilidades de expresión.\n\nA través de la escucha, la música y las propuestas individuales, en pareja y en grupo, tomaremos conciencia de cómo nos movemos, cómo nos sentimos y cómo nos relacionamos.\n\nUn espacio para encontrarte contigo mism@, abrirte al encuentro con los demás y descubrir aspectos de ti que quizá todavía no conocías.",
            '9e490c5bf3.jpg');
        $mk('fuerza', 'Fuerza y Consciencia', 'Movimiento consciente y bienestar',
            'Una forma diferente de ejercitar el cuerpo, inspirada en la antigimnasia. Combinamos movilidad articular, flexibilidad y ejercicios de fuerza con gomas y pesas, trabajando todo el cuerpo al ritmo de diferentes músicas. La respiración nos acompaña en cada movimiento, ayudándonos a conectar con el momento presente. Finalizamos con una relajación que aporta bienestar. Poco a poco, ganamos fuerza, elasticidad y conciencia corporal y mental.',
            '60197d5c3a.jpg');
        $mk('viernes', 'Tu descanso de los viernes', 'Relajación profunda y Biodanza',
            "Una sesión relajada para soltar tensiones y reconectar contigo. Comenzamos con una relajación profunda, con apoyos y cojines para estar cómodas.\n\nPoco a poco vamos despertando el cuerpo a través de la música y el movimiento consciente.\n\nEn cada encuentro exploramos diferentes temas como la gratitud, la compasión, la sensibilidad, la comodidad, la ternura, el deseo…",
            '54b11b8ba8.jpg');
        $mk('kaykal', 'Volver a sentirte · Biodanza y meditación', 'Ciclo de ocho encuentros temáticos',
            "Un sábado al mes en Kaykal. Un recorrido de ocho encuentros para explorar cualidades como la sensibilidad, la ternura, la potencia, la autocompasión…\n\nA través de la música, el movimiento y la meditación conectamos con nuestras emociones, nos expresamos libremente y descubrimos nuevas formas de sentirnos y relacionarnos.\n\nUn espacio alegre y distendido para bailar, reír y compartir. Al terminar, quien quiera puede quedarse a tomar un aperitivo o salir a comer juntas.",
            'b7b6906821.jpg');
        $mk('fit', 'Fit&Zen · En forma y en calma', 'Movimiento, fuerza y calma',
            "Trabajamos el cuerpo de forma global, movilizando las diferentes cadenas musculares mediante ejercicios de movilidad articular, fuerza y estiramientos dinámicos y progresivos.\n\nCada sesión se desarrolla alrededor de un tema y combina el trabajo físico con la atención consciente. Trabajamos a tres niveles: físico, mental y emocional.\n\nLa respiración nos acompaña durante toda la sesión, ayudándonos a habitar el cuerpo y a tomar conciencia de cómo nos encontramos. También utilizamos la música para acompañar los ejercicios.",
            'cecb8840d3.jpg');
        $mk('mind', 'Mindfulness desde cero', 'Atención plena en la vida cotidiana',
            "Te propongo un recorrido de 36 sesiones basado en el programa MBSR (Reducción del Estrés Basada en Mindfulness).\n\nAprenderemos a meditar de forma autónoma, mediante prácticas formales e informales, incorporando poco a poco la atención plena a nuestra vida cotidiana.\n\nExploraremos herramientas para relacionarnos mejor con nuestras emociones y pensamientos, y afrontar con más calma, claridad y flexibilidad las circunstancias que vayan surgiendo en nuestro día a día.",
            '10e00dc815.jpg');
        $mk('bio', 'Biodanza', 'Música, movimiento, emoción y encuentro',
            "Un encuentro semanal donde, a través de la música, el movimiento y la expresión de las emociones, exploramos nuevas formas de sentir y expresarnos con el cuerpo.\n\nLas propuestas se realizan individualmente, en pareja y en grupo, favoreciendo el encuentro con una misma y con los demás.\n\nCultivamos vitalidad y creatividad, recuperamos movimientos que habíamos dejado de explorar y descubrimos otras formas de relacionarnos y de estar en el mundo.",
            '8012076cd2.jpg');
        $mk('mayores', 'Biodanza y Mindfulness · Mayores de 55 años', null,
            "Un encuentro para personas mayores de 55 años en el que combinamos música, movimiento consciente y mindfulness.\n\nPropuestas adaptadas al grupo para favorecer la movilidad, la atención, la expresión y el encuentro con los demás.",
            null);

        $slots = [
            ['Colmenar Viejo', 'Martes · Sala Vive Yoga', 'Laboratorio de Biodanza', '11:00 – 12:30', 'lab'],
            ['Colmenar Viejo', 'Martes · Sala Vive Yoga', 'Fuerza y Consciencia', '17:45 – 18:45', 'fuerza'],
            ['Colmenar Viejo', 'Viernes · Sala Vive Yoga', 'Tu descanso de los viernes', '18:00 – 20:00', 'viernes'],
            ['Colmenar Viejo', 'Sábado · Sala Kaykal', 'Volver a sentirte · Biodanza y meditación', '10:30 – 13:30', 'kaykal'],
            ['Alcobendas', 'Jueves por la mañana · Casa de las Asociaciones', 'Fit&Zen · En forma y en calma', '10:45 – 11:45', 'fit'],
            ['Alcobendas', 'Jueves por la tarde · Polideportivo José Caballero', 'Fit&Zen · En forma y en calma', '18:00 – 19:00', 'fit'],
            ['Alcobendas', 'Jueves por la tarde · Polideportivo José Caballero', 'Mindfulness desde cero', '19:00 – 20:00', 'mind'],
            ['Alcobendas', 'Jueves por la tarde · Polideportivo José Caballero', 'Biodanza', '20:00 – 22:00', 'bio'],
            ['Mataelpino y Cerceda', 'Viernes por la mañana', 'Mataelpino · Biodanza y Mindfulness', '10:00 – 11:00', 'mayores'],
            ['Mataelpino y Cerceda', 'Viernes por la mañana', 'Cerceda · Biodanza y Mindfulness', '11:15 – 12:15', 'mayores'],
        ];
        foreach ($slots as $i => [$sede, $day, $title, $time, $act]) {
            ScheduleSlot::create(['sede' => $sede, 'day_label' => $day, 'title' => $title, 'time' => $time, 'activity_id' => $a[$act]->id, 'sort' => ($i + 1) * 10]);
        }
    }

    private function posters(): void
    {
        $rows = [
            ['taller', '2026-11', '21 de noviembre', 'Vulnerabilidad', 'Sala Kaykal · Colmenar Viejo', '00b9b61c99.jpg'],
            ['taller', '2026-11', '22 de noviembre', 'Yoga, mindfulness y biodanza', null, 'bc3ff16e18.jpg'],
            ['taller', '2026-11', '27 de noviembre', 'La gratitud', 'Vive Yoga · Colmenar Viejo', 'dc5a22198f.jpg'],
            ['taller', '2026-12', '13 de diciembre', 'Sesión especial de Navidad', null, '4f5a927f57.png'],
            ['retiro', '2026-11', '13–15 de noviembre de 2026', 'El arte de soltar', 'El Pagano · Arenas de San Pedro, Ávila', '2b3e764f27.jpg'],
            ['retiro', '2027-07', '29 de julio – 1 de agosto de 2027', 'Verano para sentir', 'Málaga', null],
            ['retiro_pasado', null, null, 'Mataelpino y Manzanares el Real', 'Centro Kadampa y Casa Ballena', 'af3639e96a.jpg'],
            ['retiro_pasado', null, '31 de julio – 2 de agosto', 'Yoga, meditación y biodanza', 'Manzanares el Real y Mataelpino · Entorno Kadampa', null],
        ];
        foreach ($rows as $i => [$kind, $month, $date, $title, $place, $img]) {
            Poster::create(['kind' => $kind, 'month' => $month, 'date_text' => $date, 'title' => $title, 'place' => $place,
                'image' => $img ? "img/$img" : null, 'sort' => ($i + 1) * 10]);
        }
    }

    private function online(): void
    {
        OnlineCard::create(['tag' => 'Para docentes', 'title' => 'Recursos de meditación para profesores', 'body' => 'Materiales y propuestas para enriquecer tus clases.', 'visual' => 'Docentes', 'sort' => 10]);
        OnlineCard::create(['tag' => 'Programa completo', 'title' => 'Curso de mindfulness', 'body' => 'Un recorrido de 36 semanas para incorporar la atención plena a la vida cotidiana.', 'visual' => '36 semanas', 'sort' => 20]);
        OnlineCard::create(['tag' => 'Meditaciones gratuitas', 'title' => 'Insight Timer', 'body' => 'Escucha mis meditaciones gratuitas en la app Insight Timer, a tu propio ritmo.', 'image' => 'img/d5d138612b.jpg',
            'link_url' => 'https://insighttimer.com/', 'link_text' => 'Ir a Insight Timer', 'sort' => 30]);
    }

    private function settings(): void
    {
        $defaults = [
            'social_whatsapp' => 'https://wa.me/34647752638',
            'social_insight' => 'https://insighttimer.com/',
            'banner_inicio' => 'img/banner-inicio.jpg',
            'banner_talleres' => 'img/banner-pequeno.jpg',
            'banner_carteles' => 'img/banner-pequeno.jpg',
            'banner_asociacion' => 'img/banner-pequeno.jpg',
            'banner_online' => 'img/banner-pequeno.jpg',
            'banner_camino' => 'img/banner-pequeno.jpg',
            'camino_foto' => 'img/70d798c19d.jpg',
            'camino_titulo' => 'Mi camino',
            'camino_intro' => 'Soy Paloma Cano y, desde niña, la música, el baile y el movimiento han formado parte de mi vida. Siempre he sentido esa conexión con el cuerpo y con la libertad de expresarme a mi manera.',
            'camino_cuerpo' => "En 1998 comencé a explorar el mundo del crecimiento personal a través del yoga. Después llegaron otras experiencias: los cinco ritmos, el *ecstatic dance*, yoga danza, la expresión corporal y la danza contemporánea. Cada una me fue acercando un poquito más a lo que buscaba.\n\nHasta que me encontré con la **Biodanza**. Y entonces comprendí que había llegado al lugar que llevaba tanto tiempo buscando.\n\n---\n\nEn 2012 llegó otro descubrimiento importante a mi vida: el **Mindfulness**. Realicé un curso en la Universidad Complutense de Madrid con Gustavo Diex, de quien aprendí muchísimo. Desde entonces, la atención plena siempre ha estado presente en mis sesiones.\n\nEl Mindfulness nos ayuda a estar más presentes, a observar lo que sucede fuera y dentro de nosotros y a conectar con lo que sentimos. Por eso me gusta combinarlo con la Biodanza: **la atención plena nos invita a detenernos y escuchar, mientras que la Biodanza nos permite expresar y vivir a través del movimiento**.\n\nHoy, de todas las disciplinas que practico y comparto, la Biodanza ocupa un lugar muy especial en mi vida. Porque reúne todo aquello que siempre me ha apasionado: **la música, el movimiento libre, la meditación, el encuentro con tus emociones, la expresión de ellas y el encuentro con los demás.**\n\nEs una forma de estar dentro y fuera, de conectar contigo mism@ y abrirte al mundo. De sentir, expresar, compartir y, sobre todo, **sentir que estás viv@**.",
        ];
        foreach ($defaults as $k => $v) {
            if (Setting::where('key', $k)->doesntExist()) {
                Setting::put($k, $v);
            }
        }
    }
}
