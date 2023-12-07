<?php
require_once('../../datos/daoEquipos.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["IdE"])) {
    $idE = $_GET["IdE"];
    $autorizar = isset($_GET["Aprobado"]) && $_GET["Aprobado"] == 1 ? true : false;

    $daoEquipos = new DAOEquipos();

    try {
        if ($autorizar) {
            $daoEquipos->autorizar($idE);
            $message = 'Equipo autorizado correctamente';
        } else {
            $daoEquipos->eliminar($idE);    
            $message = 'Equipo eliminado correctamente';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }
    $redirectURL = "../ListaEquipos.php?message=" . urlencode($message);
    header("Location: $redirectURL");
    exit();
} else {
    header("Location: ../error.php");
    exit();
}
?>
