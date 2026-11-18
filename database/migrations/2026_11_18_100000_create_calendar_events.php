<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eventos con fecha concreta: talleres, retiros (pueden durar varios días), días cerrados...
        Schema::create('calendar_events', function (Blueprint $t) {
            $t->id();
            $t->date('date');
            $t->date('end_date')->nullable();
            $t->string('kind')->default('taller');
            $t->string('title');
            $t->string('time')->nullable();
            $t->string('place')->nullable();
            $t->foreignId('activity_id')->nullable()->constrained()->nullOnDelete();
            $t->timestamps();
        });

        // Las clases del horario semanal se repiten cada semana en el calendario, salvo que se desmarque
        Schema::table('schedule_slots', function (Blueprint $t) {
            $t->boolean('in_calendar')->default(true);
        });
        // «Volver a sentirte» es un sábado al mes: sus fechas se añaden a mano como eventos
        DB::table('schedule_slots')->where('title', 'like', 'Volver a sentirte%')->update(['in_calendar' => false]);
    }

    public function down(): void
    {
        Schema::table('schedule_slots', fn (Blueprint $t) => $t->dropColumn('in_calendar'));
        Schema::dropIfExists('calendar_events');
    }
};
