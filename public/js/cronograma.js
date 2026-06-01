

$(document).ready(function () {

//1. INICIALIZAR DATE RANGE PICKER (campo de agregar nueva)
     
  $('#reservation').daterangepicker({
    locale: {
      format: 'DD/MM/YYYY',
      applyLabel: 'Aplicar',
      cancelLabel: 'Cancelar',
      fromLabel: 'Desde',
      toLabel: 'Hasta',
      customRangeLabel: 'Personalizado',
      daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
      monthNames: [
        'Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
      ],
      firstDay: 1
    },
    startDate: moment(),
    endDate: moment(),
    autoUpdateInput: true
  });


  
  // 2. CONTADOR DE FILAS
    
  function updateRowNumbers() {
    $('#activityTable tbody tr').each(function (index) {
      $(this).find('td:first').text(index + 1);
    });
  }


  // 3. AGREGAR NUEVA ACTIVIDAD
  $('#btnAgregar').on('click', function (e) {
    e.preventDefault();

    var fechas   = $('#reservation').val().trim();
    var detalles = $('#detalles').val().trim();

    // Validación básica
    if (!fechas || fechas === '') {
      alert('Por favor ingrese un rango de fechas.');
      return;
    }
    if (!detalles) {
      alert('Por favor ingrese los detalles de la actividad.');
      return;
    }

    var rowCount = $('#activityTable tbody tr').length + 1;

    var newRow = $('<tr>').html(
      '<td>' + rowCount + '</td>' +
      '<td class="td-fecha"><span class="fecha-text">' + fechas + '</span></td>' +
      '<td class="td-detalle"><span class="detalle-text">' + detalles + '</span></td>' +
      '<td class="td-acciones">' +
        '<a href="#" class="btn btn-info btn-xs btn-editar"><i class="fa fa-pencil"></i> Editar</a> ' +
        '<a href="#" class="btn btn-danger btn-xs btn-eliminar"><i class="fa fa-trash-o"></i> Eliminar</a> ' +
        '<a href="#" class="btn btn-primary btn-xs btn-guardar" style="display:none;"><i class="fa fa-save"></i> Guardar</a>' +
      '</td>'
    );

    $('#activityTable tbody').append(newRow);

    // Limpiar campos
    $('#reservation').val('');
    $('#detalles').val('');

    updateRowNumbers();
  });


  // 4. EDITAR FILA — delegación de eventos sobre tbody
  $('#activityTable tbody').on('click', '.btn-editar', function (e) {
    e.preventDefault();

    var $row = $(this).closest('tr');

    // Evitar doble edición
    if ($row.hasClass('editing')) return;
    $row.addClass('editing');

    // --- Celda de FECHA: reemplazar texto con input + daterangepicker ---
    var $tdFecha    = $row.find('.td-fecha');
    var fechaActual = $tdFecha.find('.fecha-text').text();

    var $inputFecha = $('<input>', {
      type: 'text',
      class: 'form-control input-fecha-edit',
      value: fechaActual,
      style: 'width:100%;'
    });

    $tdFecha.html($inputFecha);

    $inputFecha.daterangepicker({
      locale: {
        format: 'DD/MM/YYYY',
        applyLabel: 'Aplicar',
        cancelLabel: 'Cancelar',
        daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        monthNames: [
          'Enero','Febrero','Marzo','Abril','Mayo','Junio',
          'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
        ],
        firstDay: 1
      },
      autoUpdateInput: true
    });

    // Parsear rango actual para pre-seleccionarlo si tiene formato válido
    if (fechaActual.indexOf(' - ') !== -1) {
      var partes = fechaActual.split(' - ');
      var inicio = moment(partes[0], 'DD/MM/YYYY');
      var fin    = moment(partes[1], 'DD/MM/YYYY');
      if (inicio.isValid() && fin.isValid()) {
        $inputFecha.data('daterangepicker').setStartDate(inicio);
        $inputFecha.data('daterangepicker').setEndDate(fin);
      }
    }

    // --- Celda de DETALLE: reemplazar texto con input editable ---
    var $tdDetalle    = $row.find('.td-detalle');
    var detalleActual = $tdDetalle.find('.detalle-text').text();

    var $inputDetalle = $('<input>', {
      type: 'text',
      class: 'form-control input-detalle-edit',
      value: detalleActual,
      style: 'width:100%;'
    });

    $tdDetalle.html($inputDetalle);

    // --- Botones: ocultar Editar, mostrar Guardar ---
    $(this).hide();
    $row.find('.btn-guardar').show();
  });


  // 5. GUARDAR CAMBIOS
  $('#activityTable tbody').on('click', '.btn-guardar', function (e) {
    e.preventDefault();

    var $row = $(this).closest('tr');

    // Recuperar nuevos valores
    var nuevaFecha   = $row.find('.input-fecha-edit').val().trim();
    var nuevoDetalle = $row.find('.input-detalle-edit').val().trim();

    if (!nuevaFecha) {
      alert('La fecha no puede estar vacía.');
      return;
    }
    if (!nuevoDetalle) {
      alert('Los detalles no pueden estar vacíos.');
      return;
    }

    // Destruir instancia daterangepicker para limpiar
    var $drp = $row.find('.input-fecha-edit');
    if ($drp.data('daterangepicker')) {
      $drp.data('daterangepicker').remove();
    }

    // Restaurar celdas como texto
    $row.find('.td-fecha').html('<span class="fecha-text">' + nuevaFecha + '</span>');
    $row.find('.td-detalle').html('<span class="detalle-text">' + nuevoDetalle + '</span>');

    // Restaurar botones
    $row.find('.btn-editar').show();
    $(this).hide();
    $row.removeClass('editing');
  });


  // 6. ELIMINAR FILA
  $('#activityTable tbody').on('click', '.btn-eliminar', function (e) {
    e.preventDefault();

    if (!confirm('¿Está seguro de que desea eliminar esta actividad?')) return;

    // Destruir daterangepicker si la fila estaba en modo edición
    var $row = $(this).closest('tr');
    var $drp = $row.find('.input-fecha-edit');
    if ($drp.length && $drp.data('daterangepicker')) {
      $drp.data('daterangepicker').remove();
    }

    $row.remove();
    updateRowNumbers();
  });

});