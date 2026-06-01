<?php

namespace App\Http\Controllers;

use App\Models\FormularioPostulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;






class FormularioPostulacionController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'estudiante_ru' => 'required|exists:estudiantes,ru',
        'titulo_proyecto' => 'required|string|max:300',
        'resumen' => 'required|string|max:5000',
        'pdf_perfil' => 'required|file|mimes:pdf|max:1024',
    ]);

    $rutaPdf = $request->file('pdf_perfil')->store('perfiles', 'public');

    $postulacion = FormularioPostulacion::create([
        'estudiante_ru' => $request->estudiante_ru,
        'titulo_proyecto' => $request->titulo_proyecto,
        'resumen' => $request->resumen,
        'pdf_perfil' => $rutaPdf,
    ]);

    return redirect()
    ->route('formulario-postulacion.show', $postulacion->id)
    ->with('success', 'Formulario guardado correctamente.');
}

public function show($id)
{
    $postulacion = FormularioPostulacion::with('estudiante')->findOrFail($id);
    $estudiante = $postulacion->estudiante;

    return view('formulario', compact('postulacion', 'estudiante'));
}



public function update(Request $request, $id)
{
    $postulacion = FormularioPostulacion::findOrFail($id);

    $request->validate([
        'titulo_proyecto' => 'required|string|max:300',
        'resumen' => 'required|string|max:5000',
        'pdf_perfil' => 'nullable|file|mimes:pdf|max:1024',
    ]);

    $rutaPdf = $postulacion->pdf_perfil;

    if ($request->hasFile('pdf_perfil')) {
        if ($postulacion->pdf_perfil) {
            Storage::disk('public')->delete($postulacion->pdf_perfil);
        }

        $rutaPdf = $request->file('pdf_perfil')->store('perfiles', 'public');
    }

    $postulacion->update([
        'titulo_proyecto' => $request->titulo_proyecto,
        'resumen' => $request->resumen,
        'pdf_perfil' => $rutaPdf,
    ]);

    return redirect()
        ->route('formulario-postulacion.show', $postulacion->id)
        ->with('success', 'Formulario actualizado correctamente.');
}
}