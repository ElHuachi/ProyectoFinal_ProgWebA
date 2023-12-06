function redirectToIndex() {
    window.location.href = '../Principal/index.php';
}

function showConfirmationModal(userName) {
    $('#confirmationModal').modal('show');
    var userNameSpan = document.getElementById('userName');
    userNameSpan.textContent = userName;
}

function showErrorModal(errorMessage) {
    $('#errorModal').modal('show');
    var errorMessageElement = document.getElementById('errorMessage');
    errorMessageElement.textContent = errorMessage;

    setTimeout(function() {
        $('#errorModal').modal('hide');
    }, 1500);
}

function validateAndSubmit() {
    var tipoUsuario = document.getElementById('tipo_usuario').value;
    var usuario = document.getElementById('usuario').value;
    var password = document.getElementById('password').value;
    var nombreAuxiliar = document.getElementById('nombre_auxiliar').value;

    // Validaciones (puedes agregar más según tus necesidades)

    if (!usuario || !password) {
        showErrorModal('Por favor, completa todos los campos importantes.');
        return;
    }

    if (usuario.length < 4 || usuario.length > 15) {
        showErrorModal('El nombre de usuario debe tener entre 8 y 15 caracteres.');
        return;
    }

    if (password.length < 6 || password.length > 10) {
        showErrorModal('La contraseña debe tener entre 6 y 10 caracteres.');
        return;
    }

    if (tipoUsuario === 'auxiliar' && (nombreAuxiliar.length < 8 || nombreAuxiliar.length > 15)) {
        showErrorModal('El nombre del auxiliar debe tener entre 8 y 15 caracteres');
        return;
    }

    if (tipoUsuario === 'auxiliar' && nombreAuxiliar.length === 0) {
        showErrorModal('Por favor, ingresa el nombre del auxiliar.');
        return;
    }

    showConfirmationModal(usuario);
}

function handleTipoUsuarioChange() {
    var tipoUsuario = document.getElementById('tipo_usuario').value;
    var adminFields = document.getElementById('admin_fields');
    var auxiliarFields = document.getElementById('auxiliar_fields');

    if (tipoUsuario === 'admin') {
        adminFields.style.display = 'block';
        auxiliarFields.style.display = 'none';
    } else if (tipoUsuario === 'auxiliar') {
        adminFields.style.display = 'none';
        auxiliarFields.style.display = 'block';
    } else {
        adminFields.style.display = 'none';
        auxiliarFields.style.display = 'none';
    }
}

function registerUserInDB() {
    var tipoUsuario = document.getElementById('tipo_usuario').value;
    var usuario = document.getElementById('usuario').value;
    var password = document.getElementById('password').value;
    var nombreAuxiliar = document.getElementById('nombre_auxiliar').value;

    // Objeto con los datos a enviar al servidor
    var userData = {
        tipoUsuario: tipoUsuario,
        usuario: usuario,
        password: password,
        nombreAuxiliar: nombreAuxiliar
    };

    // Crear un formulario dinámicamente y enviarlo
    var form = document.createElement('form');
    form.action = '../Vista/Procesos/procesar_registro.php';
    form.method = 'POST';

    for (var key in userData) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = userData[key];
        form.appendChild(input);
    }

    document.body.appendChild(form);
    form.submit();
}