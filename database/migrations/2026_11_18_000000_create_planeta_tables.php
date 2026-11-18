<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fichas de actividad (lo que se ve en la ventana al pulsar la "i")
        Schema::create('activities', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('subtitle')->nullable();
            $t->text('description')->nullable();
            $t->string('image')->nullable();
            $t->timestamps();
        });

        // Calendario: cada fila es una clase en un día/lugar/hora
        Schema::create('schedule_slots', function (Blueprint $t) {
            $t->id();
            $t->string('sede');
            $t->string('day_label');
            $t->string('title');
            $t->string('time')->nullable();
            $t->foreignId('activity_id')->nullable()->constrained()->nullOnDelete();
            $t->unsignedInteger('sort')->default(0);
            $t->timestamps();
        });

        // Carteles: talleres, retiros próximos y retiros ya vividos
        Schema::create('posters', function (Blueprint $t) {
            $t->id();
            $t->string('kind');
            $t->string('month')->nullable();
            $t->string('date_text')->nullable();
            $t->string('title');
            $t->string('place')->nullable();
            $t->text('description')->nullable();
            $t->string('image')->nullable();
            $t->unsignedInteger('sort')->default(0);
            $t->timestamps();
        });

        // Tarjetas de la pestaña Online
        Schema::create('online_cards', function (Blueprint $t) {
            $t->id();
            $t->string('tag')->nullable();
            $t->string('title');
            $t->text('body')->nullable();
            $t->string('visual')->nullable();
            $t->string('image')->nullable();
            $t->string('link_url')->nullable();
            $t->string('link_text')->nullable();
            $t->unsignedInteger('sort')->default(0);
            $t->timestamps();
        });

        // Ajustes sueltos: redes sociales, texto de "Mi camino"...
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
        });
    }

    public function down(): void
    {
        foreach (['settings', 'online_cards', 'posters', 'schedule_slots', 'activities'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
