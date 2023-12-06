<?php
    require_once("../../datos/daoCoach.php");

    // Verificar si se recibieron los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener datos del formulario
        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];
        $contrasena = $_POST["contrasena"];
        $institucion = $_POST["NombreI"];
        $idTipo = "Co"; // Valor por defecto
        // Crear objeto coach con los datos
        $nuevoCoach = new coach();
        $nuevoCoach->NombreC = $nombre;
        $nuevoCoach->CorreoC = $correo;
        $nuevoCoach->Institucion = $institucion;
        $nuevoCoach->idTipo = $idTipo;
        $nuevoCoach->PassCo = $contrasena;

        // Instanciar el DAOCoach y llamar al método para insertar
        $daoCoach = new DAOCoach();
        $resultado = $daoCoach->insertarCoach($nuevoCoach);

        // Verificar el resultado de la inserción
        if ($resultado) {
            // Redirigir a la página de inicio de sesión con un mensaje de confirmación
            header("Location: ../Login.php?registro=exito");
            exit();
        } else {
            // Manejar error, redirigir a la página de registro con un mensaje de error
            header("Location: Registro.php?registro=error");
            exit();
        }
    } else {
        // Redirigir a la página de registro si no se recibieron datos por POST
        header("Location: registro.php");
        exit();
    }
?>
