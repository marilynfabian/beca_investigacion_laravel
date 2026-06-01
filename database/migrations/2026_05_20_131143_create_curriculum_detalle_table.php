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
       Schema::create('curriculum_detalle', function (Blueprint $table) {
            $table->id();

            $table->foreignId('curriculum_id')
                ->constrained('curriculum_vitae')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('seccion');
            $table->string('gestion', 20)->nullable();

            $table->string('campo_1', 255)->nullable();
            $table->string('campo_2', 255)->nullable();
            $table->string('campo_3', 255)->nullable();

            $table->timestamps();

            $table->check('seccion BETWEEN 1 AND 7');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum_detalle');
    }
};
