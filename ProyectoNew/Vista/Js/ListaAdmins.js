let AdminConfirmacion;
let idUsuarioEliminar;

document.addEventListener('DOMContentLoaded', () => {
    $("#lista").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [0, 1, 2]
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

    AdminConfirmacion = new bootstrap.Modal(document.getElementById('mdlConfirmacion'));

    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function () {
            confirmar(this.getAttribute('data-id'), this.getAttribute('data-usuario'));
        });
    });

    document.getElementById('btnConfirmar').addEventListener('click', function () {
        confirmarEliminar();
    });
});

function confirmar(id, usuario) {
    document.getElementById("spnPersona").innerText = usuario;
    idUsuarioEliminar = id;
    AdminConfirmacion.show();
}

function confirmarEliminar() {
    eliminarUsuario(idUsuarioEliminar);
}

function eliminarUsuario(id) {
    window.location.href = `../Vista/Procesos/procesar_eliminar.php?idA=${id}`;
}
