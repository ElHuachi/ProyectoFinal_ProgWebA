let EquiposConfirmacion;
let idEquipoEliminar;
let nombreEquipoEliminar;
let idEquipoAut;
let nombreEquipoAut;

document.addEventListener('DOMContentLoaded', () => {
    $("#lista").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            'colvis'
        ],
        stateSave: true,
        columnDefs: [
            { orderable: false, targets: -1 }
        ],
        order: [[1, 'asc'], [2, 'desc']]
    });

    EquiposConfirmacion = new bootstrap.Modal(document.getElementById('mdlConfirmacion'));

    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function () {
            idEquipoEliminar = this.getAttribute('data-idE');
            nombreEquipoEliminar = this.getAttribute('data-equipo');
            document.getElementById("spnPersona").innerText = nombreEquipoEliminar;
            EquiposConfirmacion.show();
        });
    });

    document.querySelectorAll('.btn-aprobar').forEach(btn => {
        btn.addEventListener('click', function () {
            idEquipoAut = this.getAttribute('data-idE');
            nombreEquipoAut = this.getAttribute('data-equipo');
            document.getElementById("spnPersona").innerText = nombreEquipoAut;
            autorizarEquipo(idEquipoAut); // Llamar a la función con el ID del equipo
        });
    });

    document.getElementById('btn-Confirmar').addEventListener('click', function () {
        confirmarEliminar();
    });    
    
    document.getElementById('btn-Autorizar').addEventListener('click', function () {
        autorizarEquipo(idEquipoAut);
    });
    
});

function confirmarEliminar() {
    window.location.href = `../Vista/Procesos/procesar_eliminar_equipo.php?IdE=${idEquipoEliminar}`;
}

function autorizarEquipo(idEquipo) {
    window.location.href = `../Vista/Procesos/procesar_eliminar_equipo.php?IdE=${idEquipo}&Aprobado=1`;
}

