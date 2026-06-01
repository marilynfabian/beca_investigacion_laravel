<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;

class HistorialController extends Controller
{
   public function index($estudiante_ru)
{
    $estudiante = Estudiante::with([
        'carreraFacultad',
        'postulaciones' => function ($query) {
            $query->orderBy('fecha', 'desc');
        },
    ])->where('ru', $estudiante_ru)->firstOrFail();

    $postulacion = $estudiante->postulaciones->first();

    return view('historial', compact('estudiante', 'postulacion'));
} 
}