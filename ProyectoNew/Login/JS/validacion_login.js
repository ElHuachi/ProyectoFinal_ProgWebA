document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const tipoUsuarioSelect = document.getElementById("tipo_usuario");
    const correoLabel = document.querySelector("label[for='correo']");
    const correoInput = document.getElementById("correo");

    tipoUsuarioSelect.addEventListener("change", function () {
        const selectedOption = tipoUsuarioSelect.value;
        
        if (selectedOption === "coach") {
            correoLabel.textContent = "Correo:";
            correoInput.name = "correo";
            correoInput.removeAttribute("pattern");
        } else {
            correoLabel.textContent = "Usuario:";
            correoInput.name = "usuario";
            correoInput.pattern = "[0-9a-zA-Z]+";
        }
    });

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const tipoUsuario = tipoUsuarioSelect.value;
        const correo = correoInput.value;
        const contrasena = document.getElementById("contrasena").value;
        if (correo === "" || contrasena === "") {
            alert("Todos los campos son obligatorios. Por favor, complete todos los campos.");
        } else {
            form.submit();
        }
    });
});
