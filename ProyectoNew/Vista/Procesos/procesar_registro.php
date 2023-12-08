<?php
require_once('../../datos/daoAdmin.php');
require_once('../../datos/daoAux.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoUsuario = $_POST["tipoUsuario"];
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Inicializa el mensaje por defecto
    $message = '';

    if (empty($tipoUsuario) || empty($usuario) || empty($password)) {
        // Campos obligatorios vacíos
        $message = 'Todos los campos son obligatorios. Por favor, complete todos los campos.';
    } else {
        $idTipo = ($tipoUsuario === "admin") ? "Ad" : "Ax";

        if ($tipoUsuario === "admin") {
            $obj = new admin();
            $obj->idTipo = $idTipo;
            $obj->UsuarioAd = $usuario;
            $obj->PassAd = $password;

            $daoAdmin = new DaoAdmin();

            try {
                $result = $daoAdmin->insertar($obj);

                if ($result) {
                    // Registro exitoso
                    $message = 'Usuario administrador registrado correctamente';
                    $redirectURL = "/ProyectoNew/Vista/ListaAdmin.php?message=" . urlencode($message);
                    header("Location: $redirectURL");
                    exit();
                } else {
                    // Error en el registro
                    $message = 'Error al registrar el usuario administrador';
                }
            } catch (Exception $e) {
                $message = 'Error: ' . $e->getMessage();
            }
        } elseif ($tipoUsuario === "auxiliar") {
            // Verifica si se proporcionó el nombreAuxiliar
            if (empty($_POST["nombreAuxiliar"])) {
                $message = 'El campo "Nombre Auxiliar" es obligatorio para usuarios auxiliares.';
            } else {
                $obj = new auxiliar();
                $obj->NombreAx = $_POST["nombreAuxiliar"];
                $obj->UsuarioAx = $usuario;
                $obj->PassAx = $password;
                $obj->idTipo = $idTipo;
                $daoAux = new DaoAux();
                try {
                    $result = $daoAux->insertar($obj);  
                    if ($result) {
                        // Registro exitoso
                        $message = 'Usuario auxiliar registrado correctamente';
                        $redirectURL = "/ProyectoNew/Vista/ListaAuxiliares.php?message=" . urlencode($message);
                        header("Location: $redirectURL");
                        exit();
                    } else {
                        // Error en el registro
                        $message = 'Error al registrar el usuario auxiliar';
                    }
                } catch (Exception $e) {
                    $message = 'Error: ' . $e->getMessage();
                }
            }
        }
    }

    // Redirige a la página correspondiente con el mensaje de error
    $redirectURL = "/ProyectoNew/Vista/RegistroUsuario.php?message=" . urlencode($message);
    header("Location: $redirectURL");
    exit();
}
?>
