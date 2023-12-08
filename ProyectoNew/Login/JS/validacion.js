document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const equipo = document.getElementById("Equipo").value;
        const estudiante1 = document.getElementById("Estudiante1").value;
        const estudiante2 = document.getElementById("Estudiante2").value;
        const estudiante3 = document.getElementById("Estudiante3").value;
        const nombreI = document.getElementById("NombreI").value;

        if (equipo === "" || estudiante1 === "" || estudiante2 === "" || estudiante3 === "" || nombreI === "") {
            // alert("Todos los campos son obligatorios. Por favor, complete todos los campos.");
        } else {
            form.submit();
        }
    });
});

function guardarEquipo() {
    // Envía el formulario de manera síncrona
    document.querySelector("form").submit();
}
