<?php
session_start();

require_once("../../datos/daoCoach.php");
require_once("../../datos/daoAdmin.php");
require_once("../../datos/daoAux.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoUsuario = $_POST["tipo_usuario"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $dao = null;
    $usuario = null;

    if ($tipoUsuario == "coach") {
        $dao = new DAOCoach();
        $usuario = $dao->autenticarCoach($correo, $contrasena);

        if ($usuario) {
            $_SESSION['tipo_usuario'] = $tipoUsuario;
            $_SESSION['usuario_id'] = $usuario->IdC; // Ajusta esto según tu estructura de objetos
            $_SESSION['usuario_nombre'] = $usuario->NombreC; // Ajusta esto según tu estructura de objetos
            header("Location: ../../Principal/index.php");
            exit();
        }
    } elseif ($tipoUsuario == "administrador") {
        $dao = new DAOAdmin();
        $usuario = $dao->autenticarAdministrador($correo, $contrasena);

        if ($usuario) {
            $_SESSION['tipo_usuario'] = $tipoUsuario;
            header("Location: ../../Principal/index.php");
            exit();
        }
    } elseif ($tipoUsuario == "auxiliar") {
        $dao = new DAOAux();
        $usuario = $dao->autenticarAuxiliar($correo, $contrasena);

        if ($usuario) {
            $_SESSION['tipo_usuario'] = $tipoUsuario;
            header("Location: ../../Principal/index.php");
            exit();
        }
    }

    if (!$usuario) {
        header("Location: ../login.php?error=1"); // Autenticación fallida
        exit();
    }
} else {
    header("Location: ../login.php?error=2"); // Método de solicitud no válido
    exit();
}
