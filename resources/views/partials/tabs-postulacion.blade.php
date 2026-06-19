<div class="x_content">
    <div role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

            <li role="presentation" class="{{ request()->routeIs('formulario-postulacion.*') ? 'active' : '' }}">
                <a href="{{ isset($postulacion) ? route('formulario-postulacion.show', $postulacion->id) : '#' }}">
                    Formulario de Postulación
                </a>
            </li>

            <li role="presentation" class="{{ request()->routeIs('cronograma.*') ? 'active' : '' }}">
                <a href="{{ isset($postulacion) ? route('cronograma.create', $postulacion->id) : '#' }}">
                    Cronograma
                </a>
            </li>

            <li role="presentation" class="{{ request()->routeIs('curriculum.*') ? 'active' : '' }}">
                <a href="{{ isset($estudiante) ? route('curriculum.create', $estudiante->ru) : '#' }}">
                    Currículum
                </a>
            </li>

            <li role="presentation" class="{{ request()->routeIs('historial.*') ? 'active' : '' }}">
                <a href="{{ isset($estudiante) ? route('historial.index', $estudiante->ru) : '#' }}">
                    Historial
                </a>
            </li>

        </ul>
    </div>
</div>