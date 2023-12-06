let InstiConfirmacion;
let nombreInstiEliminar;

document.addEventListener('DOMContentLoaded', () => {
    InstiConfirmacion = new bootstrap.Modal(document.getElementById('mdlConfirmacion'));

    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function () {
            nombreInstiEliminar = this.getAttribute('data-NombreI');
            document.getElementById("spnPersona").innerText = nombreInstiEliminar;
            InstiConfirmacion.show();
        });
    });

    document.getElementById('btnConfirmar').addEventListener('click', function () {
        confirmarEliminar();
    });    
});

function confirmarEliminar() {
    window.location.href = `../Vista/Procesos/procesar_eliminar_institucion.php?NombreI=${nombreInstiEliminar}`;
}
