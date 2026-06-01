@extends('layouts.app')

@push('styles')
<link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
<link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
@endpush

@section('content')
@php
    $secciones = [
        1 => ['titulo' => 'AUXILIAR DE DOCENCIA', 'icono' => 'fa-graduation-cap', 'campos' => [
            'campo_1' => ['label' => 'Tiempo',   'placeholder' => 'Ej: 01/2016'],
            'campo_2' => ['label' => 'Materia',  'placeholder' => 'Ej: Cálculo I'],
        ]],
        2 => ['titulo' => 'DISERTANTE DE EVENTOS ACADÉMICOS', 'icono' => 'fa-microphone', 'campos' => [
            'campo_1' => ['label' => 'Tipo de Evento', 'placeholder' => 'Ej: Seminario / Curso / Taller'],
            'campo_2' => ['label' => 'Tema de Evento', 'placeholder' => 'Ej: Inteligencia Artificial'],
        ]],
        3 => ['titulo' => 'PARTICIPANTE EN EVENTOS ACADÉMICOS (CURSOS VARIOS)', 'icono' => 'fa-users', 'campos' => [
            'campo_1' => ['label' => 'Tipo de Evento', 'placeholder' => 'Ej: Seminario / Curso / Taller'],
            'campo_2' => ['label' => 'Tema de Evento', 'placeholder' => 'Ej: Estadística Aplicada'],
        ]],
        4 => ['titulo' => 'PARTICIPANTE EN FERIAS CIENTÍFICAS', 'icono' => 'fa-flask', 'campos' => [
            'campo_1' => ['label' => 'Nombre de la Feria', 'placeholder' => 'Ej: Feria de Ciencias UATF'],
            'campo_2' => ['label' => 'Tema Presentado',    'placeholder' => 'Ej: Energías renovables'],
        ]],
        5 => ['titulo' => 'PRODUCCIÓN INTELECTUAL', 'icono' => 'fa-book', 'campos' => [
            'campo_1' => ['label' => 'Documento Publicado', 'placeholder' => 'Ej: Artículo científico en Revista XYZ'],
        ]],
        6 => ['titulo' => 'DISERTANTE CURSOS DE FORMACIÓN I+D', 'icono' => 'fa-lightbulb-o', 'campos' => [
            'campo_1' => ['label' => 'Tema', 'placeholder' => 'Ej: Metodología de investigación'],
        ]],
        7 => ['titulo' => 'PARTICIPANTE DE CURSOS DE FORMACIÓN I+D', 'icono' => 'fa-pencil', 'campos' => [
            'campo_1' => ['label' => 'Evento', 'placeholder' => 'Ej: Curso de Formación en I+D'],
        ]],
    ];
@endphp

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Formulario Vitae</h3>
        </div>
    </div>

    <div class="clearfix"></div>

    <div id="cv-alert" class="alert" style="display:none;"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">

                    <p class="text-muted font-weight-bold" style="margin-bottom:10px;">
                        Seleccione una sección para completar su Curriculum Vitae:
                    </p>
                    <div class="row" style="margin-bottom:20px;">
                        <div class="col-xs-12">
                            <div class="btn-group">
                                <button id="dropdown-label" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                                    <span id="dropdown-text">Seleccionar sección</span> <span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu">
                                    @foreach($secciones as $numero => $seccion)
                                        <li>
                                            <a href="#" class="dropdown-section-link" data-target="sec-{{ $numero }}">
                                                {{ $numero }} · {{ $seccion['titulo'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid" style="padding:0;">
                        @foreach($secciones as $numero => $seccion)
                            <div id="sec-{{ $numero }}" class="form-section" style="display:none;">
                                <div class="x_title">
                                    <h2>
                                        <i class="fa {{ $seccion['icono'] }}" style="margin-right:6px;color:#1abb9c;"></i>
                                        {{ $numero }}. {{ $seccion['titulo'] }}
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>

                                <form class="cv-create-form" data-section="{{ $numero }}">
                                    @csrf
                                    <input type="hidden" name="curriculum_id" value="{{ $curriculum->id }}">
                                    <input type="hidden" name="seccion" value="{{ $numero }}">

                                    <div class="form-group">
                                        <label>Gestión:</label>
                                        <input type="text" class="form-control" name="gestion" placeholder="Ej: 2023">
                                    </div>

                                    @foreach($seccion['campos'] as $nombre_campo => $config)
                                        <div class="form-group">
                                            <label>{{ $config['label'] }}:</label>
                                            <input type="text" class="form-control" name="{{ $nombre_campo }}" placeholder="{{ $config['placeholder'] }}">
                                        </div>
                                    @endforeach

                                    <div style="text-align:right; margin-top:8px;">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-save"></i> Guardar
                                        </button>
                                    </div>
                                </form>

                                <div
                                    class="table-responsive cv-table-wrapper"
                                    data-section="{{ $numero }}"
                                    style="margin-top:15px; {{ count($detalles[$numero] ?? []) ? '' : 'display:none;' }}"
                                >
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Gestión</th>
                                                @foreach($seccion['campos'] as $nombre_campo => $config)
                                                    <th>{{ $config['label'] }}</th>
                                                @endforeach
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-sec-{{ $numero }}">
                                            @foreach(($detalles[$numero] ?? []) as $index => $detalle)
                                                <tr data-row-id="{{ $detalle->id }}">
                                                    <td class="row-number">{{ $index + 1 }}</td>

                                                    <td>
                                                        <span class="text-value" data-field="gestion">{{ $detalle->gestion ?? '' }}</span>
                                                        <input type="text" class="form-control edit-input" name="gestion" value="{{ $detalle->gestion ?? '' }}" style="display:none;" placeholder="Ej: 2023">
                                                    </td>

                                                    @foreach($seccion['campos'] as $nombre_campo => $config)
                                                        <td>
                                                            <span class="text-value" data-field="{{ $nombre_campo }}">{{ $detalle->$nombre_campo ?? '' }}</span>
                                                            <input type="text" class="form-control edit-input" name="{{ $nombre_campo }}" value="{{ $detalle->$nombre_campo ?? '' }}" style="display:none;" placeholder="{{ $config['placeholder'] }}">
                                                        </td>
                                                    @endforeach

                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn-edit">Editar</button>
                                                        <button type="button" class="btn btn-success btn-xs btn-save" style="display:none;">Guardar</button>
                                                        <button type="button" class="btn btn-default btn-xs btn-cancel" style="display:none;">Cancelar</button>
                                                        <button type="button" class="btn btn-danger btn-xs btn-delete">Eliminar</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <hr>
                            </div>
                        @endforeach
                    </div>

                    <div class="submit-wrapper text-right" style="margin-top:20px;">
                        <button type="button" class="btn btn-primary btn-lg" id="btn-enviar">
                            Enviar Formulario
                        </button>
                        <button type="button" class="btn btn-success btn-lg" id="btn-preview">
                            VISTA PREVIA
                        </button>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const sections = document.querySelectorAll('.form-section');
    const dropdownLinks = document.querySelectorAll('.dropdown-section-link');
    const dropdownText = document.getElementById('dropdown-text');
    
    const sectionFields = @json(collect($secciones)->mapWithKeys(fn($s, $n) => [$n => array_keys($s['campos'])]));

    const sectionPlaceholders = @json(collect($secciones)->mapWithKeys(fn($s, $n) => [
        $n => collect($s['campos'])->mapWithKeys(fn($c, $k) => [$k => $c['placeholder'] ?? ''])->toArray()
    ]));

    function showAlert(message, type = 'success') {
        const alert = document.getElementById('cv-alert');
        alert.className = 'alert alert-' + type;
        alert.textContent = message;
        alert.style.display = 'block';

        setTimeout(() => {
            alert.style.display = 'none';
        }, 2500);
    }

    function showSection(targetId) {
        sections.forEach(section => section.style.display = 'none');

        const target = document.getElementById(targetId);
        if (target) target.style.display = 'block';
    }

    function refreshNumbers(tbody) {
        tbody.querySelectorAll('tr[data-row-id]').forEach((row, index) => {
            row.querySelector('.row-number').textContent = index + 1;
        });
    }

    function buildRow(section, detalle) {
        const fields = ['gestion', ...(sectionFields[section] || [])];
        const row = document.createElement('tr');
        row.dataset.rowId = detalle.id;

        let html = `<td class="row-number"></td>`;

        fields.forEach(field => {
            const value = detalle[field] || '';
            const placeholder = field === 'gestion' ? 'Ej: 2023' : (sectionPlaceholders[section]?.[field] || '');
            html += `
                <td>
                    <span class="text-value" data-field="${field}">${value}</span>
                    <input type="text" class="form-control edit-input" name="${field}" value="${value}" style="display:none;" placeholder="${placeholder}">
                </td>
            `;
        });

        html += `
            <td>
                <button type="button" class="btn btn-info btn-xs btn-edit">Editar</button>
                <button type="button" class="btn btn-success btn-xs btn-save" style="display:none;">Guardar</button>
                <button type="button" class="btn btn-default btn-xs btn-cancel" style="display:none;">Cancelar</button>
                <button type="button" class="btn btn-danger btn-xs btn-delete">Eliminar</button>
            </td>
        `;

        row.innerHTML = html;
        return row;
    }

    function setEditMode(row, editing) {
        row.querySelectorAll('.text-value').forEach(el => el.style.display = editing ? 'none' : 'inline');
        row.querySelectorAll('.edit-input').forEach(el => el.style.display = editing ? 'block' : 'none');

        row.querySelector('.btn-edit').style.display = editing ? 'none' : 'inline-block';
        row.querySelector('.btn-save').style.display = editing ? 'inline-block' : 'none';
        row.querySelector('.btn-cancel').style.display = editing ? 'inline-block' : 'none';
    }

    dropdownLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            showSection(this.dataset.target);
            if (dropdownText) dropdownText.textContent = this.textContent.trim();
        });
    });

    document.querySelectorAll('.cv-create-form').forEach(form => {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const section = this.dataset.section;
            const data = new FormData(this);

            const response = await fetch("{{ route('curriculum.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: data,
            });

            const result = await response.json();

            if (!result.success) {
                showAlert('No se pudo guardar el registro.', 'danger');
                return;
            }

            const tbody = document.getElementById('tbody-sec-' + section);
            const wrapper = document.querySelector(`.cv-table-wrapper[data-section="${section}"]`);
            const row = buildRow(section, result.detalle);

            tbody.appendChild(row);
            wrapper.style.display = 'block';
            refreshNumbers(tbody);
            this.reset();

            showAlert('Registro guardado correctamente.');
        });
    });

    document.addEventListener('click', async function (event) {
        const row = event.target.closest('tr[data-row-id]');
        if (!row) return;

        if (event.target.classList.contains('btn-edit')) {
            row.querySelectorAll('.edit-input').forEach(input => {
                input.dataset.original = input.value;
            });

            setEditMode(row, true);
        }

        if (event.target.classList.contains('btn-cancel')) {
            row.querySelectorAll('.edit-input').forEach(input => {
                input.value = input.dataset.original || '';
            });

            setEditMode(row, false);
        }

        if (event.target.classList.contains('btn-save')) {
            const id = row.dataset.rowId;
            const data = new FormData();

            row.querySelectorAll('.edit-input').forEach(input => {
                data.append(input.name, input.value);
            });

            data.append('_method', 'PUT');

            const response = await fetch(`/curriculum-detalle/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: data,
            });

            const result = await response.json();

            if (!result.success) {
                showAlert('No se pudo actualizar el registro.', 'danger');
                return;
            }

            row.querySelectorAll('.edit-input').forEach(input => {
                const text = row.querySelector(`.text-value[data-field="${input.name}"]`);
                text.textContent = input.value;
            });

            setEditMode(row, false);
            showAlert('Registro actualizado correctamente.');
        }

        if (event.target.classList.contains('btn-delete')) {
            if (!confirm('¿Eliminar este registro?')) return;

            const id = row.dataset.rowId;
            const data = new FormData();
            data.append('_method', 'DELETE');

            const response = await fetch(`/curriculum-detalle/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: data,
            });

            const result = await response.json();

            if (!result.success) {
                showAlert('No se pudo eliminar el registro.', 'danger');
                return;
            }

            const tbody = row.closest('tbody');
            const wrapper = row.closest('.cv-table-wrapper');

            row.remove();
            refreshNumbers(tbody);

            if (tbody.querySelectorAll('tr[data-row-id]').length === 0) {
                wrapper.style.display = 'none';
            }

            showAlert('Registro eliminado correctamente.');
        }
    });

    showSection('sec-1');
});
</script>
@endpush