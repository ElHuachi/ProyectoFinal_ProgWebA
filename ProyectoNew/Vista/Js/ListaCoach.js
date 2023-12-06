let CoachConfirmacion;
let idCoachEliminar;
let CoachEliminar;

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

    CoachConfirmacion = new bootstrap.Modal(document.getElementById('mdlConfirmacion'));

    // Agregamos un listener al botón eliminar para pasar el valor adecuado
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function () {
            idCoachEliminar = this.getAttribute('data-idC');
            CoachEliminar = this.getAttribute('data-usuario');
            document.getElementById("spnPersona").innerText = CoachEliminar;
            CoachConfirmacion.show();
        });
    });
});

function eliminarCoach(){
    window.location.href = `../Vista/Procesos/procesar_eliminar_coach.php?IdC=${idCoachEliminar}`;
}
