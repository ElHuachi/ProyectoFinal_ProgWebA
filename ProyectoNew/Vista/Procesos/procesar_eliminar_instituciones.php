<?php
require_once('../../datos/DAOCoach.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["NombreI"])) {
    $nombreI = $_POST["NombreI"];

    $daoCoach = new DAOCoach();

    try {
        $daoCoach->eliminarInstitucion($nombreI);
        $message = 'Institución eliminada correctamente';
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }

    // Puedes redirigir al index con un mensaje de confirmación o error
    $redirectURL = "../ListaInstituciones.php?message=" . urlencode($message);
    header("Location: $redirectURL");
    exit();
} else {
    // Puedes redirigir a una página de error si se accede directamente sin el parámetro necesario
    header("Location: ../error.php");
    exit();
}
?>
