<!-- CRONOGRAMA -->
@extends('layouts.app')

@push('styles')
<link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Cronograma de Actividades</h3>
        </div>
    </div>

    <div class="clearfix"></div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin-bottom:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <h2>Agregar nueva actividad:</h2>

                <div class="x_content">
                    <form method="POST" action="{{ route('cronograma.store') }}">
                        @csrf

                        <input type="hidden" name="postulacion_id" value="{{ $postulacion->id }}">

                        <div class="form-nueva-actividad row">
                            <div class="row col-md-12 col-sm-12 col-xs-12">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input
                                            type="text"
                                            style="width: 100%"
                                            name="reservation"
                                            id="reservation"
                                            class="form-control"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-pencil"></i>
                                        </span>
                                        <input
                                            type="text"
                                            name="descripcion"
                                            id="detalles"
                                            class="form-control"
                                            placeholder="Descripción de la actividad"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-success w-100">
                                      <i class="fa fa-plus"></i> Guardar Actividad
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </form>

                    <br>

                    <div class="table-responsive">
                        <table id="activityTable" class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FECHA INICIO - FIN</th>
                                    <th>DETALLES</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cronogramas as $index => $actividad)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $actividad->fecha_inicio }} - {{ $actividad->fecha_fin }}</td>
                                        <td>{{ $actividad->descripcion }}</td>
                                        <td>
                                            <button class="btn btn-info btn-xs" type="button">Editar</button>
                                            <button class="btn btn-danger btn-xs" type="button">Eliminar</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No hay actividades registradas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
<script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
{--- <script src="{{ asset('js/cronograma.js') }}"></script>---}


@endpush