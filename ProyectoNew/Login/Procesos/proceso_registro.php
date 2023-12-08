<?php
require_once("../../datos/daoCoach.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
    $correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : "";
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : "";
    $institucion = isset($_POST["NombreI"]) ? trim($_POST["NombreI"]) : "";
    $idTipo = "Co";

    if (empty($nombre) || empty($correo) || empty($contrasena) || empty($institucion)) {
        header("Location: Registro.php?registro=campos_vacios");
        exit();
    }

    $nuevoCoach = new coach();
    $nuevoCoach->NombreC = $nombre;
    $nuevoCoach->CorreoC = $correo;
    $nuevoCoach->Institucion = $institucion;
    $nuevoCoach->idTipo = $idTipo;
    $nuevoCoach->PassCo = $contrasena;

    $daoCoach = new DAOCoach();
    $resultado = $daoCoach->insertarCoach($nuevoCoach);

    if ($resultado) {
        header("Location: ../Login.php?registro=exito");
        exit();
    } else {
        header("Location: Registro.php?registro=error");
        exit();
    }
} else {
    header("Location: registro.php");
    exit();
}
?>
