<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro/Edicion de equipos</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link rel="icon" href="https://lh6.googleusercontent.com/DQqOseiOF2DibeQSu3EApJu3EE7j7JIVBEiJqEcLE1ScAIBUdYfRki5lDMPRYkuTQ8VdKHnmJ6GMV9gW7y17X5AbHYBfG9e8eT-WT2q13BgJ0HiW">
</head>

<body>
    <?php

    require_once("../datos/daoCoach.php");
    $daoCoach = new DAOCoach();
    $coaches = $daoCoach->obtenerTodos();
    session_start();
    $nombreCoach = $_SESSION['usuario_nombre'];
    require_once('../datos/daoEquipos.php');
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    // Obtener el ID del equipo a editar desde la URL
    $idEquipoEditar = isset($_GET["IdE"]) ? $_GET["IdE"] : null;

    // Obtener datos del equipo si se proporciona un ID
    $equipoEditar = null;
    if ($idEquipoEditar) {
        $daoEquipos = new DAOEquipos();
        $equipoEditar = $daoEquipos->obtenerUno($idEquipoEditar);
    }


    ?>
    <div class="container">
        <h1><?php echo $equipoEditar ? 'Editar Equipo' : 'Registrar Equipo'; ?></h1>
        <form action="Procesos/procesar_form.php" method="post">
            <input type="hidden" name="idEquipoEditar" value="<?php echo $equipoEditar ? $equipoEditar->IdE : ''; ?>">

            <label for="Equipo">Nombre de Equipo:</label>
            <input type="text" id="Equipo" name="Equipo" value="<?php echo $equipoEditar ? $equipoEditar->NombreEquipo : ''; ?>" required>

            <label for="Estudiante1">Estudiante 1:</label>
            <input type="text" id="Estudiante1" name="Estudiante1" value="<?php echo $equipoEditar ? $equipoEditar->Estudiante1 : ''; ?>" required>

            <label for="Estudiante2">Estudiante 2:</label>
            <input type="text" id="Estudiante2" name="Estudiante2" value="<?php echo $equipoEditar ? $equipoEditar->Estudiante2 : ''; ?>" required>

            <label for="Estudiante3">Estudiante 3:</label>
            <input type="text" id="Estudiante3" name="Estudiante3" value="<?php echo $equipoEditar ? $equipoEditar->Estudiante3 : ''; ?>" required>
            <div>
                <input type="hidden" id="Coach" name="Coach" value="<?php echo $nombreCoach; ?>">
            </div>
            <div>
                <label for="NombreI">Nombre de Institución:</label>
                <select id="NombreI" name="NombreI" required>
                    <?php
                    // Obtener la lista de instituciones desde el DAOCoach
                    $instituciones = $daoCoach->obtenerInstitucion();
                    // Mostrar las opciones en el select
                    foreach ($instituciones as $institucion) {
                        $selected = ($equipoEditar && $equipoEditar->Institucion == $institucion->NombreI) ? "selected" : "";
                        echo "<option value='" . $institucion->NombreI . "' $selected>" . $institucion->NombreI . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="FotoEquipo">Foto:</label>
                <input type="file" id="foto" name="FotoEquipo" accept="image/*" value="<?php echo $equipoEditar ? $equipoEditar->FotoEquipo : ''; ?>" required>
            </div>
            <div class="button-container">
                <input type="button" value="<?php echo $equipoEditar ? 'Guardar' : 'Registrarse'; ?>" id="Registrar" class="submit-button" onclick="guardarEquipo();">
                <input type="button" value="Regresar" id="Back" class="submit-button" onclick="window.location.href='../Vista/listaEquipos.php';">
            </div>
        </form>
    </div>
</body>
<script src="../dt/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
<script src="JS/validacion.js"></script>

</html>