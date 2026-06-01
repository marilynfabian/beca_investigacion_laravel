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
       Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('ru', 30)->unique();
            $table->string('nombre', 100);
            $table->string('apellidos', 150);
            $table->string('correo', 150)->unique();

            $table->foreignId('carrera_facultad_id')
                ->constrained('facultad_carrera')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
