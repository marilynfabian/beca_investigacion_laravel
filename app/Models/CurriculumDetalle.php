<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumDetalle extends Model
{
    protected $table = 'curriculum_detalle';

    protected $fillable = [
        'curriculum_id',
        'seccion',
        'gestion',
        'campo_1',
        'campo_2',
        'campo_3',
    ];
}