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

    AdminConfirmacion = document.getElementById('mdlConfirmacion'); // Fix the ID here
    AdminConfirmacion.addEventListener('show.bs.modal', event => {
        let clave = event.relatedTarget.value;
        document.getElementById("spnPersona").innerText =
            event.relatedTarget.closest('tr').children[1].innerText;
        document.getElementById("btnConfirmar").value = clave;
    });
});

function confirmar(btn) {
    const mdlEliminar = new bootstrap.Modal('#mdlConfirmacion'); // Fix the typo here
    mdlEliminar.show(btn);
}