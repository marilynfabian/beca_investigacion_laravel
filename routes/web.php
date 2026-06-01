<?php



use App\Http\Controllers\FormularioPostulacionController;
use App\Http\Controllers\CronogramaController;
use App\Http\Controllers\CurriculumController;

Route::get('/curriculum/{estudiante_ru}', [CurriculumController::class, 'create'])
    ->name('curriculum.create');

Route::post('/curriculum', [CurriculumController::class, 'store'])
    ->name('curriculum.store');

Route::get('/cronograma/{postulacion_id}', [CronogramaController::class, 'create'])
    ->name('cronograma.create');

Route::post('/cronograma', [CronogramaController::class, 'store'])
    ->name('cronograma.store');


Route::post('/formulario-postulacion', [FormularioPostulacionController::class, 'store'])
    ->name('formulario-postulacion.store');

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('index');
});

Route::get('/formulario', function () {
    return view('formulario');
})->name('formulario');

Route::get('/vitae', function () {
    return view('vitae');
})->name('vitae');

/*Route::get('/cronograma', function () {
    return view('cronograma');
})->name('cronograma');
*/
Route::get('/historial', function () {
    return view('historial');
})->name('historial');


Route::get('/prueba', function () {
    return view('prueba');
})->name('prueba');
Route::post('/upload-files', function () {
    return response()->json([
        'success' => true
    ]);
})->name('upload.files');

Route::put('/curriculum-detalle/{detalle}', [CurriculumController::class, 'update'])
    ->name('curriculum.update');

Route::delete('/curriculum-detalle/{detalle}', [CurriculumController::class, 'destroy'])
    ->name('curriculum.destroy');


use App\Http\Controllers\HistorialController;

Route::get('/historial/{estudiante_ru}', [HistorialController::class, 'index'])
    ->name('historial.index');

Route::post('/formulario-postulacion', [FormularioPostulacionController::class, 'store'])
    ->name('formulario-postulacion.store');

Route::get('/formulario-postulacion/{id}/edit', [FormularioPostulacionController::class, 'edit'])
    ->name('formulario-postulacion.edit');



Route::get('/formulario-postulacion/{id}', [FormularioPostulacionController::class, 'show'])
    ->name('formulario-postulacion.show');

Route::put('/formulario-postulacion/{id}', [FormularioPostulacionController::class, 'update'])
    ->name('formulario-postulacion.update');