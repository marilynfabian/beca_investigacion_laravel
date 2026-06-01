<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formulario_postulacion', function (Blueprint $table) {
            $table->id();
            $table->string('estudiante_ru', 30);
            $table->string('titulo_proyecto', 300);
            $table->text('resumen');
            $table->string('pdf_perfil', 255);
            $table->timestamp('fecha')->useCurrent();
            $table->timestamps();

            $table->foreign('estudiante_ru')
                ->references('ru')
                ->on('estudiantes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulario_postulacion');
    }
};
