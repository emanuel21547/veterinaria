<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')
                  ->constrained('mascotas')
                  ->onDelete('cascade');
            $table->foreignId('veterinario_id')
                  ->constrained('veterinarios')
                  ->onDelete('cascade');
            $table->dateTime('fecha_consulta');
            $table->decimal('peso', 8, 2)->nullable();    // kg
            $table->decimal('talla', 8, 2)->nullable();   // cm

            // ── Secciones del expediente clínico ──
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('antecedentes_alergias')->nullable();
            $table->text('antecedentes_lesiones')->nullable();
            $table->text('antecedentes_patologicas')->nullable();
            $table->text('historial_alimentacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
