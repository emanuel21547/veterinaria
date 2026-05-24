<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn([
                'antecedentes_alergias',
                'antecedentes_lesiones',
                'antecedentes_patologicas',
                'historial_alimentacion'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->text('antecedentes_alergias')->nullable();
            $table->text('antecedentes_lesiones')->nullable();
            $table->text('antecedentes_patologicas')->nullable();
            $table->text('historial_alimentacion')->nullable();
        });
    }
};
