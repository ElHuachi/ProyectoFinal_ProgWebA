let ConcursosConfirmacion;

document.addEventListener('DOMContentLoaded', () => {
    $("#lista").DataTable({
        // Configuración de DataTables
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

    ConcursosConfirmacion = new bootstrap.Modal(document.getElementById('mdlConfirmacion'));

    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function () {
            let idConcurso = this.getAttribute('data-idc');
            let nombreConcurso = this.getAttribute('data-nombre');
            document.getElementById("spnPersona").innerText = nombreConcurso;
            document.getElementById("btn-Confirmar").setAttribute('data-idc', idConcurso);
            ConcursosConfirmacion.show();
        });
    });

    document.getElementById('btn-Confirmar').addEventListener('click', function () {
        let idConcursoEliminar = this.getAttribute('data-idc');

        // Redirigir a la página de procesamiento de eliminación con el ID del concurso
        window.location.href = `Procesos/procesar_eliminar_concursos.php?id=${idConcursoEliminar}`;
    });

    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', function () {
            let idConcursoEditar = this.getAttribute('data-idc');
            window.location.href = `editarConcurso.php?IdC=${idConcursoEditar}`;
        });
    });
});
