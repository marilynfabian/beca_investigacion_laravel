<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    protected $table = 'cronograma';

    protected $fillable = [
        'postulacion_id',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
    ];
}
