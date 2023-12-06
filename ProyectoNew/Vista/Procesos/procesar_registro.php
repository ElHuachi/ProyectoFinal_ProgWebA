<?php
require_once('../../datos/daoAdmin.php');
require_once('../../datos/daoAux.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoUsuario = $_POST["tipoUsuario"];
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Obtener idTipo según el tipo de usuario
    $idTipo = ($tipoUsuario === "admin") ? "Ad" : "Ax";

    // Crear instancias de los DAOs según el tipo de usuario
    if ($tipoUsuario === "admin") {
        $obj = new admin();
        $obj->idTipo = $idTipo;
        $obj->UsuarioAd = $usuario;
        $obj->PassAd = $password;

        $daoAdmin = new DaoAdmin();

        try {
            // Utilizar una consulta preparada para evitar SQL injection
            $result = $daoAdmin->insertar($obj);

            if ($result) {
                // Registro exitoso
                $message = 'Usuario administrador registrado correctamente';
            } else {
                // Error en el registro
                $message = 'Error al registrar el usuario administrador';
            }
        } catch (Exception $e) {
            // Manejar cualquier excepción
            $message = 'Error: ' . $e->getMessage();
        }
    } elseif ($tipoUsuario === "auxiliar") {
        $obj = new auxiliar();
        $obj->NombreAx = $_POST["nombreAuxiliar"];
        $obj->UsuarioAx = $usuario;
        $obj->PassAx = $password;
        $obj->idTipo = $idTipo;

        $daoAux = new DaoAux();

        try {
            // Utilizar una consulta preparada para evitar SQL injection
            $result = $daoAux->insertar($obj);

            if ($result) {
                // Registro exitoso
                $message = 'Usuario auxiliar registrado correctamente';
            } else {
                // Error en el registro
                $message = 'Error al registrar el usuario auxiliar';
            }
        } catch (Exception $e) {
            // Manejar cualquier excepción
            $message = 'Error: ' . $e->getMessage();
        }
    }

    // Redirige al index con mensaje de confirmación o error
    $redirectURL = "../../Principal/index.php?message=" . urlencode($message);
    header("Location: $redirectURL");
    exit();
}
?>
