
<?php
$admin = new admin();

// Variables para almacenar el estado de validación de los campos del formulario
$valId = $valIdTipo = $valUsuarioId = $valPassAd = "";

// Verificar si se ha enviado el formulario y procesar los datos
if (count($_POST) == 1 && isset($_POST["id"]) && is_numeric($_POST["id"])) {
    // Obtener la información del usuario con ese id
    $dao = new DAOUsuario();
    $usuario = $dao->obtenerUno($_POST["id"]);
} elseif (count($_POST) > 1) {
    // Validar los campos del formulario
    $valId = $valIdTipo = $valUsuarioId = $valPassAd = "is-invalid";
    $valido = true;
    if (
        isset($_POST["Usuario"]) &&
        (strlen(trim($_POST["Usuario"])) > 3 && strlen(trim($_POST["Usuario"])) < 51) &&
        preg_match("/^[a-zA-Z.\s]+$/", $_POST["Usuario"])
    ) {
        $valUsuarioId = "is-valid";
    } else {
        $valido = false;
    }
    if (
        isset($_POST["Password"]) &&
        (strlen(trim($_POST["Password"])) >= 6 && strlen(trim($_POST["Password"])) < 16)
    ) {
        $valPassword = "is-valid";
    } else {
        $valido = false;
    }

    // Asignar los valores del formulario al objeto de usuario
    $admin->id = isset($_POST["Id"]) ? trim($_POST["Id"]) : 0;
    $admin->idTipo = isset($_POST["Tipo"]) ? trim($_POST["Tipo"]) : "";
    $admin->UsuarioAd = isset($_POST["Usuario"]) ? trim($_POST["Usuario"]) : "";
    $usuario->PassAd = isset($_POST["Password"]) ? $_POST["Password"] : "";

    if ($valido) {
        // Usar el método agregar del dao
        $dao = new DAOUsuario();

        if ($usuario->id == 0) {
            if ($dao->agregar($usuario) == 0) {
                $_SESSION["msj"] = "danger-Error al intentar guardar";
            } else {
                $_SESSION["msj"] = "success-El usuario ha sido almacenado exitosamente";
                // Al finalizar el guardado redireccionar a la lista
                header("Location: listaAdmin.php");
            }
        } else {
            if ($dao->editar($usuario)) {
                $_SESSION["msj"] = "success-El usuario ha sido almacenado exitosamente";
                // Al finalizar el guardado redireccionar a la lista
                header("Location: listaAdmin.php");
            } else {
                $_SESSION["msj"] = "danger-Error al intentar guardar";
            }
        }
    }
}
