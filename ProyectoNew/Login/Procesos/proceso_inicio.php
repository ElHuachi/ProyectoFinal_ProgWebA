<?php
session_start(); // Inicia la sesión al principio del script

require_once("../../datos/daoCoach.php");
require_once("../../datos/daoAdministrador.php");
require_once("../../datos/daoAuxiliar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoUsuario = $_POST["tipo_usuario"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    switch ($tipoUsuario) {
        case "coach":
            $dao = new DAOCoach();
            $usuario = $dao->autenticarCoach($correo, $contrasena);
            break;
        case "administrador":
            $dao = new DAOAdmin();
            $usuario = $dao->autenticarAdministrador($correo, $contrasena);
            break;
        case "auxiliar":
            $dao = new DAOAux();
            $usuario = $dao->autenticarAuxiliar($correo, $contrasena);
            break;
        default:
            $usuario = null;
    }

    if ($usuario) {
        // Guarda el tipo de usuario en la sesión
        $_SESSION['tipo_usuario'] = $tipoUsuario;

        // Puedes guardar otros datos del usuario si es necesario
        // $_SESSION['usuario_id'] = $usuario->id;

        // Redirige al área correspondiente según el tipo de usuario
        header("Location: ../../Principal/index.php");
        exit();
    } else {
        // Manejar error de autenticación, redirigir al formulario de inicio de sesión con un mensaje de error
        header("Location: ../login.php?error=1");
        exit();
    }
} else {
    // Redirigir a la página de inicio de sesión si no se recibieron datos por POST
    header("Location: ../login.php?error=2");
    exit();
}
?>
