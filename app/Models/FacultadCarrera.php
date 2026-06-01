<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultadCarrera extends Model
{
    protected $table = 'facultad_carrera';

    protected $fillable = [
        'facultad',
        'carrera',
    ];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'carrera_facultad_id');
    }
}