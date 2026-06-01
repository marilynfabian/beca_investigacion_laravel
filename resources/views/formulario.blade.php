<!-- FORMULARIO -->
@extends('layouts.app')

@push('styles')
<link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/starrr/dist/starrr.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
@endpush

@section('content')
@php
    $postulacion = $postulacion ?? null;
@endphp

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Llenado de Datos</h3>
        </div>
    </div>

    <div class="x_content text-right">
        <div class="buttons">
            <button type="button" class="btn btn-info btn-lg">
                Imprimir Convocatoria
            </button>
        </div>
    </div>

    <div class="clearfix"></div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Revise el formulario:</strong>
            <ul style="margin-bottom:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ $postulacion ? route('formulario-postulacion.update', $postulacion->id) : route('formulario-postulacion.store') }}"
        enctype="multipart/form-data"
        id="formPostulacion"
    >
        @csrf

        @if($postulacion)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <br>
                        <label for="titulo_proyecto">TÍTULO DEL PROYECTO:</label>
                        <br>
                        <small>(máximo 300 letras)</small>
                        <input
                            type="text"
                            id="titulo_proyecto"
                            class="form-control"
                            maxlength="300"
                            name="titulo_proyecto"
                            value="{{ old('titulo_proyecto', $postulacion->titulo_proyecto ?? '') }}"
                            required
                        >

                        <br>

                        <label>RESUMEN DEL PROYECTO:</label>
                        <br>
                        <small>(máximo 5000 letras)</small>

                        <div class="x_content">
                            <div id="alerts"></div>

                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
                                <div class="btn-group-text">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font">
                                        <i class="fa fa-font"></i><b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu"></ul>
                                </div>

                                <div class="btn-group-text">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size">
                                        <i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a data-edit="fontSize 5"><p style="font-size:17px">Grande</p></a></li>
                                        <li><a data-edit="fontSize 3"><p style="font-size:14px">Normal</p></a></li>
                                        <li><a data-edit="fontSize 1"><p style="font-size:11px">Pequeño</p></a></li>
                                    </ul>
                                </div>

                                <div class="btn-group-text">
                                    <a class="btn" data-edit="bold" title="Bold"><i class="fa fa-bold"></i></a>
                                    <a class="btn" data-edit="italic" title="Italic"><i class="fa fa-italic"></i></a>
                                    <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                    <a class="btn" data-edit="underline" title="Underline"><i class="fa fa-underline"></i></a>
                                </div>

                                <div class="btn-group-text">
                                    <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                    <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                    <a class="btn" data-edit="outdent" title="Reduce indent"><i class="fa fa-dedent"></i></a>
                                    <a class="btn" data-edit="indent" title="Indent"><i class="fa fa-indent"></i></a>
                                </div>

                                <div class="btn-group-text">
                                    <a class="btn" data-edit="justifyleft" title="Align Left"><i class="fa fa-align-left"></i></a>
                                    <a class="btn" data-edit="justifycenter" title="Center"><i class="fa fa-align-center"></i></a>
                                    <a class="btn" data-edit="justifyright" title="Align Right"><i class="fa fa-align-right"></i></a>
                                    <a class="btn" data-edit="justifyfull" title="Justify"><i class="fa fa-align-justify"></i></a>
                                </div>

                                <div class="btn-group-text">
                                    <a class="btn" data-edit="undo" title="Undo"><i class="fa fa-undo"></i></a>
                                    <a class="btn" data-edit="redo" title="Redo"><i class="fa fa-repeat"></i></a>
                                </div>
                            </div>

                            <div id="editor-one" class="editor-wrapper">{!! old('resumen', $postulacion->resumen ?? '') !!}</div>

                            <textarea name="resumen" id="resumen" style="display:none;" required>{{ old('resumen', $postulacion->resumen ?? '') }}</textarea>

                            <br>
                        </div>

                        <br>
                        <label>PDF DEL PERFIL:</label>
                        <br>
                        <small>
                            (1 MB máximo)
                            @if($postulacion)
                                - Si no selecciona otro PDF, se conservará el archivo actual.
                            @endif
                        </small>
                        <br><br>

                        @if($postulacion && $postulacion->pdf_perfil)
                            <div class="alert alert-success" style="display:flex; align-items:center; gap:8px;">
                                <i class="fa fa-check-circle"></i>
                                <span>PDF actual:</span>
                                <a href="{{ asset('storage/' . $postulacion->pdf_perfil) }}" target="_blank">
                                    Ver / descargar archivo
                                </a>
                            </div>
                        @endif

                        <div class="col-md-12 col-sm-12 col-xs-12" style="padding:0;">
                            <div class="x_panel">
                                <div class="x_content">
                                    <input
                                        type="file"
                                        name="pdf_perfil"
                                        id="pdf_perfil"
                                        class="form-control"
                                        accept="application/pdf"
                                        {{ $postulacion ? '' : 'required' }}
                                    >

                                    <p id="nombreArchivo" class="text-success" style="margin-top:8px; display:none;">
                                        <i class="fa fa-check-circle"></i>
                                        <span></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="submit-wrapper text-right">
                            <button type="submit" id="validarFormulario" class="btn btn-primary">
                                {{ $postulacion ? 'Actualizar Formulario' : 'Validar Formulario' }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
<script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
<script src="{{ asset('vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
<script src="{{ asset('vendors/google-code-prettify/src/prettify.js') }}"></script>
<script src="{{ asset('vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
<script src="{{ asset('vendors/switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>
<script src="{{ asset('vendors/autosize/dist/autosize.min.js') }}"></script>
<script src="{{ asset('vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }}"></script>
<script src="{{ asset('vendors/starrr/dist/starrr.js') }}"></script>
<script src="{{ asset('vendors/dropzone/dist/min/dropzone.min.js') }}"></script>

<script>
    document.getElementById('formPostulacion').addEventListener('submit', function (event) {
        document.getElementById('resumen').value = document.getElementById('editor-one').innerHTML;

        const pdfInput = document.getElementById('pdf_perfil');
        const archivo = pdfInput.files[0];

        if (archivo && archivo.size > 1024 * 1024) {
            event.preventDefault();

            mostrarErrorPdf('El PDF no debe superar 1 MB.');
            pdfInput.value = '';
        }
    });

    document.getElementById('pdf_perfil').addEventListener('change', function () {
        const archivo = this.files[0];
        const mensaje = document.getElementById('nombreArchivo');

        limpiarErrorPdf();

        if (!archivo) {
            mensaje.style.display = 'none';
            return;
        }

        if (archivo.type !== 'application/pdf') {
            mostrarErrorPdf('Solo se permiten archivos PDF.');
            this.value = '';
            mensaje.style.display = 'none';
            return;
        }

        if (archivo.size > 1024 * 1024) {
            mostrarErrorPdf('El PDF no debe superar 1 MB.');
            this.value = '';
            mensaje.style.display = 'none';
            return;
        }

        mensaje.querySelector('span').textContent = ' Archivo seleccionado: ' + archivo.name;
        mensaje.style.display = 'block';
    });

    function mostrarErrorPdf(texto) {
        let error = document.getElementById('errorPdf');

        if (!error) {
            error = document.createElement('p');
            error.id = 'errorPdf';
            error.className = 'text-danger';
            error.style.marginTop = '8px';

            const input = document.getElementById('pdf_perfil');
            input.parentNode.appendChild(error);
        }

        error.innerHTML = '<i class="fa fa-times-circle"></i> ' + texto;
        error.style.display = 'block';
    }

    function limpiarErrorPdf() {
        const error = document.getElementById('errorPdf');

        if (error) {
            error.style.display = 'none';
        }
    }
</script>
@endpush