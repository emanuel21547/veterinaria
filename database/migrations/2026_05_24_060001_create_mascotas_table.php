<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dueno_id')
                  ->nullable()
                  ->constrained('duenos')
                  ->onDelete('set null');
            $table->string('nombre');
            $table->string('especie')->nullable();       // Perro, Gato, Ave…
            $table->string('raza')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('tipo_sangre', 20)->nullable();
            $table->string('comportamiento')->nullable();
            $table->boolean('es_adoptado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
