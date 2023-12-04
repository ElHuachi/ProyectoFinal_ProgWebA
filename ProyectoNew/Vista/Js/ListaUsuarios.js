let UsuariosConfirmacion;

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

    UsuariosConfirmacion = new bootstrap.Modal(document.getElementById('mdlConfirmacion'), {
        backdrop: 'static'
    });

    $('#lista').on('click', '.btn-editar', function () {
        var userId = $(this).data('id');
        window.location.href = 'usuario.php?id=' + userId;
    });

    $('#lista').on('click', '.btn-eliminar', function () {
        var userId = $(this).attr('data-id'); // Cambiado de 'value' a 'data-id'
        // Mostrar el modal de confirmación
        confirmarEliminar(userId);
    });

    function confirmarEliminar(userId) {
        // Mostrar el modal de confirmación
        UsuariosConfirmacion.show();

        // Configurar el evento de confirmación
        $('#btnConfirmar').on('click', function () {
            // Ocultar el modal de confirmación
            UsuariosConfirmacion.hide();

            // Enviar solicitud AJAX para eliminar el usuario
            $.ajax({
                type: 'POST',
                url: 'usuarioUtil.php',
                data: { eliminar: userId },
                success: function (response) {
                    console.log(response);
                    // Recargar la página después de la eliminación exitosa
                    location.reload();
                },
                error: function (error) {
                    console.error('Error en la solicitud AJAX: ', error);
                }
            });
        });
    }
});