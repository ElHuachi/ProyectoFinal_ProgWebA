<?php
// Proceso de eliminacion de Administrador
require_once('../../datos/daoAdmin.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["idA"])) {
    $idA = $_GET["idA"];

    $daoAdmin = new DaoAdmin();

    try {
        $result = $daoAdmin->eliminar($idA);

        if ($result) {
            $message = 'Usuario eliminado correctamente';
        } else {
            $message = 'Error al eliminar el usuario';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }

    // Redirige al index con mensaje de confirmación o error
    $redirectURL = "../ListaAdmin.php?message=" . urlencode($message);
    header("Location: $redirectURL");
    exit();
} else {
    // Redirige a una página de error si se accede directamente a procesar_eliminar.php sin el ID
    header("Location: ../error.php");
    exit();
}
?>