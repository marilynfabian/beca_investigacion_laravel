<?php

namespace App\Http\Controllers;

use App\Models\CurriculumDetalle;
use App\Models\CurriculumVitae;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use App\Models\FormularioPostulacion;

class CurriculumController extends Controller
{
    public function create($estudiante_ru)
{
    $estudiante = Estudiante::where('ru', $estudiante_ru)->firstOrFail();

    $postulacion = FormularioPostulacion::where('estudiante_ru', $estudiante->ru)
        ->latest('fecha')
        ->first();

    $curriculum = CurriculumVitae::firstOrCreate([
        'estudiante_ru' => $estudiante->ru,
    ]);

    $detalles = CurriculumDetalle::where('curriculum_id', $curriculum->id)
        ->orderBy('seccion')
        ->orderBy('id')
        ->get()
        ->groupBy('seccion');

    return view('vitae', compact('estudiante', 'postulacion', 'curriculum', 'detalles'));
}


    public function store(Request $request)
{
    $request->validate([
        'curriculum_id' => 'required|exists:curriculum_vitae,id',
        'seccion' => 'required|integer|min:1|max:7',
        'gestion' => 'nullable|string|max:20',
        'campo_1' => 'nullable|string|max:255',
        'campo_2' => 'nullable|string|max:255',
        'campo_3' => 'nullable|string|max:255',
    ]);

    $detalle = CurriculumDetalle::create($request->only([
        'curriculum_id', 'seccion', 'gestion', 'campo_1', 'campo_2', 'campo_3',
    ]));

    return response()->json(['success' => true, 'detalle' => $detalle]);
}

public function update(Request $request, $id)
{
    $detalle = CurriculumDetalle::findOrFail($id);

    $request->validate([
        'gestion' => 'nullable|string|max:20',
        'campo_1' => 'nullable|string|max:255',
        'campo_2' => 'nullable|string|max:255',
        'campo_3' => 'nullable|string|max:255',
    ]);

    $detalle->update($request->only(['gestion', 'campo_1', 'campo_2', 'campo_3']));

    return response()->json(['success' => true, 'detalle' => $detalle]);
}

public function destroy($id)
{
    $detalle = CurriculumDetalle::findOrFail($id);
    $detalle->delete();

    return response()->json(['success' => true]);
}
    
}