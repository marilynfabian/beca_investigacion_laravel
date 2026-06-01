<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumVitae extends Model
{
    protected $table = 'curriculum_vitae';

    protected $fillable = [
        'estudiante_ru',
    ];

    public function detalles()
    {
        return $this->hasMany(CurriculumDetalle::class, 'curriculum_id');
    }
}