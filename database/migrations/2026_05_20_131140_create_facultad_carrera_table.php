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
       Schema::create('facultad_carrera', function (Blueprint $table) {
            $table->id();
            $table->string('facultad', 150);
            $table->string('carrera', 150);
            $table->timestamps();

            $table->unique(['facultad', 'carrera']);
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facultad_carrera');
    }
};
