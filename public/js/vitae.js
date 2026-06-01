(function ($) {
  "use strict";
  var sections = {
    "sec-1": {
      numero: 1,
      titulo: "AUXILIAR DE DOCENCIA",
      campos: [
        { id: "s1-gestion",  label: "Gestión" },
        { id: "s1-tiempo",   label: "Tiempo"  },
        { id: "s1-materia",  label: "Materia" }
      ]
    },
    "sec-2": {
      numero: 2,
      titulo: "DISERTANTE DE EVENTOS ACADÉMICOS",
      campos: [
        { id: "s2-gestion", label: "Gestión"        },
        { id: "s2-tipo",    label: "Tipo de Evento" },
        { id: "s2-tema",    label: "Tema de Evento" }
      ]
    },
    "sec-3": {
      numero: 3,
      titulo: "PARTICIPANTE EN EVENTOS ACADÉMICOS",
      campos: [
        { id: "s3-gestion", label: "Gestión"        },
        { id: "s3-tipo",    label: "Tipo de Evento" },
        { id: "s3-tema",    label: "Tema de Evento" }
      ]
    },
    "sec-4": {
      numero: 4,
      titulo: "PARTICIPANTE EN FERIAS CIENTÍFICAS",
      campos: [
        { id: "s4-gestion", label: "Gestión"           },
        { id: "s4-nombre",  label: "Nombre de la Feria"},
        { id: "s4-tema",    label: "Tema Presentado"   }
      ]
    },
    "sec-5": {
      numero: 5,
      titulo: "PRODUCCIÓN INTELECTUAL",
      campos: [
        { id: "s5-gestion",   label: "Gestión"             },
        { id: "s5-documento", label: "Documento Publicado"  }
      ]
    },
    "sec-6": {
      numero: 6,
      titulo: "DISERTANTE CURSOS DE FORMACIÓN I+D",
      campos: [
        { id: "s6-gestion", label: "Gestión" },
        { id: "s6-tema",    label: "Tema"    }
      ]
    },
    "sec-7": {
      numero: 7,
      titulo: "PARTICIPANTE DE CURSOS DE FORMACIÓN I+D",
      campos: [
        { id: "s7-gestion", label: "Gestión" },
        { id: "s7-evento",  label: "Evento"  }
      ]
    }
  };

  // Estado de registros por sección: { "sec-1": [ {id, ...campos}, ... ] }
  var registros = {};
  var editando  = {};   // { "sec-1": rowId | null }
  var contadores = {};  // contador de IDs por sección

  // Inicializar estado
  $.each(sections, function (secId) {
    registros[secId]  = [];
    editando[secId]   = null;
    contadores[secId] = 0;
  });

 
  //  NAVEGACIÓN


  
   // Muestra sólo la sección indicada y actualiza el botón activo.
   
  function mostrarSeccion(secId) {
    // Ocultar todas
    $(".form-section").removeClass("active").hide();

    // Mostrar la seleccionada
    $("#" + secId).addClass("active").show();

    // Resaltar botón numérico correspondiente
    $(".btn-num").removeClass("active-section");
    $(".btn-num[data-target='" + secId + "']").addClass("active-section");

    // Actualizar label del dropdown
    var num = sections[secId] ? sections[secId].numero : "";
    var tit = sections[secId] ? sections[secId].titulo : secId;
    $("#dropdown-text").text(num + " · " + tit);
  }

  // Clic en botones numéricos (1-7)
  $(document).on("click", ".btn-num", function () {
    var target = $(this).data("target");
    if (target) mostrarSeccion(target);
  });

  // Clic en ítems del dropdown
  $(document).on("click", ".dropdown-section-link", function (e) {
    e.preventDefault();
    var target = $(this).data("target");
    if (target) mostrarSeccion(target);
  });

  
  //  HELPERS
  

  /** Lee los valores de los campos del formulario de una sección. */
  function leerFormulario(secId) {
    var cfg    = sections[secId];
    var datos  = {};
    $.each(cfg.campos, function (_, campo) {
      datos[campo.id] = $("#" + campo.id).val().trim();
    });
    return datos;
  }

  /** Limpia los campos del formulario de una sección. */
  function limpiarFormulario(secId) {
    var cfg = sections[secId];
    $.each(cfg.campos, function (_, campo) {
      $("#" + campo.id).val("");
    });
  }

  /** Valida que ningún campo esté vacío. */
  function validarFormulario(secId) {
    var cfg   = sections[secId];
    var valido = true;
    $.each(cfg.campos, function (_, campo) {
      if ($("#" + campo.id).val().trim() === "") {
        valido = false;
        return false; // break
      }
    });
    return valido;
  }

  /** Rellena el formulario con los datos de una fila para editar. */
  function cargarEnFormulario(secId, rowId) {
    var fila = $.grep(registros[secId], function (r) { return r._id === rowId; })[0];
    if (!fila) return;
    var cfg = sections[secId];
    $.each(cfg.campos, function (_, campo) {
      $("#" + campo.id).val(fila[campo.id]);
    });
  }

  
  //  RENDERIZAR TABLA

  function renderizarTabla(secId) {
    var cfg    = sections[secId];
    var datos  = registros[secId];
    var $tbody = $("#tbody-" + secId);
    var $wrap  = $("#table-wrapper-" + secId);

    $tbody.empty();

    if (datos.length === 0) {
      $wrap.hide();
      return;
    }

    $wrap.show();

    $.each(datos, function (idx, fila) {
      var $tr = $("<tr>");

      // Resaltar fila en edición
      if (editando[secId] === fila._id) {
        $tr.addClass("editing-row");
      }

      // Número de fila
      $tr.append($("<td>").text(idx + 1));

      // Celdas de datos
      $.each(cfg.campos, function (_, campo) {
        $tr.append($("<td>").text(fila[campo.id]));
      });

      // Acciones
      var $btnEditar = $("<button>")
        .addClass("btn btn-warning btn-xs")
        .attr("data-sec", secId)
        .attr("data-id", fila._id)
        .html('<i class="fa fa-pencil"></i> Editar')
        .css("margin-right", "4px");

      var $btnEliminar = $("<button>")
        .addClass("btn btn-danger btn-xs")
        .attr("data-sec", secId)
        .attr("data-id", fila._id)
        .html('<i class="fa fa-trash"></i> Eliminar');

      var $tdAcciones = $("<td>").append($btnEditar).append($btnEliminar);
      $tr.append($tdAcciones);

      $tbody.append($tr);
    });
  }

  //  GUARDAR (nuevo o edición)
  
  function guardarRegistro(secId) {
    if (!validarFormulario(secId)) {
      alert("Por favor, complete todos los campos antes de guardar.");
      return;
    }

    var datos = leerFormulario(secId);

    if (editando[secId] !== null) {
      // ── Modo edición: actualizar fila existente
      var idx = -1;
      $.each(registros[secId], function (i, r) {
        if (r._id === editando[secId]) { idx = i; return false; }
      });
      if (idx !== -1) {
        datos._id = editando[secId];
        registros[secId][idx] = datos;
      }
      editando[secId] = null;
      $("#cancel-" + secId).hide();
      $("#save-" + secId).html('<i class="fa fa-save"></i> Guardar');
    } else {
      // ── Modo nuevo: agregar fila
      contadores[secId]++;
      datos._id = contadores[secId];
      registros[secId].push(datos);
    }

    limpiarFormulario(secId);
    renderizarTabla(secId);
  }

  //  CANCELAR EDICIÓN

  function cancelarEdicion(secId) {
    editando[secId] = null;
    limpiarFormulario(secId);
    $("#cancel-" + secId).hide();
    $("#save-" + secId).html('<i class="fa fa-save"></i> Guardar');
    renderizarTabla(secId);
  }

  //  EVENTOS DE TABLA: Editar y Eliminar
  

  // Editar fila
  $(document).on("click", ".btn-warning.btn-xs", function () {
    var secId = $(this).data("sec");
    var rowId = parseInt($(this).data("id"), 10);

    // Si ya había otro en edición, avisar
    if (editando[secId] !== null && editando[secId] !== rowId) {
      if (!confirm("Hay una edición en curso. ¿Desea descartarla y editar esta fila?")) return;
    }

    editando[secId] = rowId;
    cargarEnFormulario(secId, rowId);
    renderizarTabla(secId);

    // Cambiar botón guardar a "Actualizar" y mostrar cancelar
    $("#save-" + secId).html('<i class="fa fa-check"></i> Actualizar');
    $("#cancel-" + secId).show();

    // Scroll suave al formulario
    $("html, body").animate({
      scrollTop: $("#form-" + secId).offset().top - 80
    }, 300);
  });

  // Eliminar fila
  $(document).on("click", ".btn-danger.btn-xs", function () {
    var secId = $(this).data("sec");
    var rowId = parseInt($(this).data("id"), 10);

    if (!confirm("¿Está seguro de eliminar este registro?")) return;

    // Si se elimina la fila en edición, limpiar formulario
    if (editando[secId] === rowId) {
      cancelarEdicion(secId);
    }

    registros[secId] = $.grep(registros[secId], function (r) {
      return r._id !== rowId;
    });
    renderizarTabla(secId);
  });

  //  EVENTOS DE BOTONES: Guardar y Cancelar por sección
 
  $.each(sections, function (secId) {
    $("#save-" + secId).on("click", function () {
      guardarRegistro(secId);
    });
    $("#cancel-" + secId).on("click", function () {
      cancelarEdicion(secId);
    });
  });

  
  //  ENVIAR FORMULARIO (recopilar todo)
 
  $("#btn-enviar").on("click", function () {
    var totalRegistros = 0;
    $.each(sections, function (secId) {
      totalRegistros += registros[secId].length;
    });

    if (totalRegistros === 0) {
      alert("No ha guardado ningún registro en ninguna sección. Complete al menos una sección antes de enviar.");
      return;
    }

    // Aquí puedes hacer un POST/AJAX con los datos
    var payload = {};
    $.each(sections, function (secId, cfg) {
      payload[secId] = {
        titulo: cfg.titulo,
        registros: registros[secId]
      };
    });

    console.log("Datos a enviar:", payload);
    alert("Formulario enviado correctamente.\n(Revise la consola para ver los datos registrados.)");
  });

 
  //  VISTA PREVIA
  
  $("#btn-preview").on("click", function () {
    var html = "<h3 style='font-family:sans-serif'>VISTA PREVIA - CURRICULUM VITAE</h3>";
    var hayDatos = false;

    $.each(sections, function (secId, cfg) {
      if (registros[secId].length === 0) return; // skip empty
      hayDatos = true;

      html += "<h4 style='font-family:sans-serif;color:#1abb9c'>" + cfg.numero + ". " + cfg.titulo + "</h4>";
      html += "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;width:100%;font-family:sans-serif;font-size:13px;'>";

      // Encabezados
      html += "<tr style='background:#f5f5f5'>";
      html += "<th>#</th>";
      $.each(cfg.campos, function (_, campo) {
        html += "<th>" + campo.label + "</th>";
      });
      html += "</tr>";

      // Filas
      $.each(registros[secId], function (idx, fila) {
        html += "<tr>";
        html += "<td>" + (idx + 1) + "</td>";
        $.each(cfg.campos, function (_, campo) {
          html += "<td>" + (fila[campo.id] || "") + "</td>";
        });
        html += "</tr>";
      });

      html += "</table><br>";
    });

    if (!hayDatos) {
      alert("No hay registros guardados para mostrar en la vista previa.");
      return;
    }

    var win = window.open("", "_blank");
    win.document.write("<html><head><title>Vista Previa - Vitae</title></head><body style='padding:30px'>" + html + "</body></html>");
    win.document.close();
  });

  //  INICIALIZACIÓN: mostrar sección 1 por defecto
  
  mostrarSeccion("sec-1");

})(jQuery);