// validacion.js
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const tipoUsuario = document.getElementById("tipo_usuario").value;
        const correo = document.getElementById("correo").value;
        const contrasena = document.getElementById("contrasena").value;

        if (tipoUsuario === "" || correo === "" || contrasena === "") {
            alert("Todos los campos son obligatorios. Por favor, complete todos los campos.");
        } else {
            form.submit();
        }
    });
});

function guardarEquipo() {
    // Envía el formulario
    $("form").submit();
}
