<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'ru',
        'nombre',
        'apellidos',
        'correo',
        'carrera_facultad_id',
    ];

    public function carreraFacultad()
    {
        return $this->belongsTo(FacultadCarrera::class, 'carrera_facultad_id');
    }

    public function postulaciones()
    {
        return $this->hasMany(FormularioPostulacion::class, 'estudiante_ru', 'ru');
    }
}