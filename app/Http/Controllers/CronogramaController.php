<?php

namespace App\Http\Controllers;

use App\Models\Cronograma;
use App\Models\FormularioPostulacion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CronogramaController extends Controller
{
  public function create($postulacion_id)
{
    $postulacion = FormularioPostulacion::with('estudiante')->findOrFail($postulacion_id);
    $estudiante = $postulacion->estudiante;

    $cronogramas = Cronograma::where('postulacion_id', $postulacion->id)
        ->orderBy('fecha_inicio')
        ->get();

    return view('cronograma', compact('postulacion', 'estudiante', 'cronogramas'));
} 

    public function store(Request $request)
{
    $request->validate([
        'postulacion_id' => 'required|exists:formulario_postulacion,id',
        'reservation' => 'required|string',
        'descripcion' => 'required|string|max:500',
    ]);

    [$fechaInicio, $fechaFin] = explode(' - ', $request->reservation);

    $fechaInicio = Carbon::createFromFormat('d/m/Y', trim($fechaInicio))->format('Y-m-d');
    $fechaFin = Carbon::createFromFormat('d/m/Y', trim($fechaFin))->format('Y-m-d');

    Cronograma::create([
        'postulacion_id' => $request->postulacion_id,
        'fecha_inicio' => $fechaInicio,
        'fecha_fin' => $fechaFin,
        'descripcion' => $request->descripcion,
    ]);

    return back()->with('success', 'Actividad guardada correctamente.');
}
}