<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormularioPostulacion;

class FormularioPostulacion extends Model
{
    protected $table = 'formulario_postulacion';

    protected $fillable = [
        'estudiante_ru',
        'titulo_proyecto',
        'resumen',
        'pdf_perfil',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_ru', 'ru');
    }

    public function cronogramas()
    {
        return $this->hasMany(Cronograma::class, 'postulacion_id');
    }
}

