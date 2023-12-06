<?php
session_start(); // Inicia la sesión al principio del script

require_once("../../datos/daoCoach.php");
require_once("../../datos/daoAdministrador.php");
require_once("../../datos/daoAuxiliar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoUsuario = $_POST["tipo_usuario"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $dao = null;
    $usuario = null;

    if ($tipoUsuario == "coach") {
        $dao = new DAOCoach();
        $usuario = $dao->autenticarCoach($correo, $contrasena);
    } elseif ($tipoUsuario == "administrador") {
        $dao = new DAOAdmin();
        $usuario = $dao->autenticarAdministrador($correo, $contrasena);
    } elseif ($tipoUsuario == "auxiliar") {
        $dao = new DAOAux();
        $usuario = $dao->autenticarAuxiliar($correo, $contrasena);
    }

    if ($usuario) {
        // Guarda el tipo de usuario en la sesión
        $_SESSION['tipo_usuario'] = $tipoUsuario;

        // Puedes guardar otros datos del usuario si es necesario
        // $_SESSION['usuario_id'] = $usuario->id;

        header("Location: ../../Principal/index.php");
        exit();
    } else {
        header("Location: ../login.php?error=1");
        exit();
    }
} else {
    // Redirigir a la página de inicio de sesión si no se recibieron datos por POST
    header("Location: ../login.php?error=2");
    exit();
}
?>
