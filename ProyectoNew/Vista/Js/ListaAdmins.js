let AdminConfirmacion;

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

    // Agregamos un listener al botón eliminar para pasar el valor adecuado
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function () {
            confirmar(this.getAttribute('data-id'), this.getAttribute('data-usuario'));
        });
    });
});

function confirmar(id, usuario) {
    document.getElementById("spnPersona").innerText = usuario;
    document.getElementById("btnConfirmar").value = id;
    AdminConfirmacion.show();
}
