<?php
require_once('../../datos/daoCoach.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["IdC"])){
    $idC = $_GET["IdC"];

    $daoCoach = new DAOCoach();

    try {
        $result = $daoCoach->eliminar($idC);

        if ($result) {
            $message = 'Usuario eliminado correctamente';
        } else {
            $message = 'Error al eliminar el usuario';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
    }
    $redirectURL = "../ListaCoach.php?message=" . urlencode($message);
    header("Location: $redirectURL");
    exit();
}

?>