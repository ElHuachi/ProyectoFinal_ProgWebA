<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link rel="icon" href="https://lh6.googleusercontent.com/DQqOseiOF2DibeQSu3EApJu3EE7j7JIVBEiJqEcLE1ScAIBUdYfRki5lDMPRYkuTQ8VdKHnmJ6GMV9gW7y17X5AbHYBfG9e8eT-WT2q13BgJ0HiW">
</head>

<body>
    <?php
    // session_start();
    // if (!isset($_SESSION["usuario"])) {
    //     header("Location:index.html");
    // }
    // require('../Principal/menu.php');
    require_once("../datos/daoCoach.php");
    $daoCoach = new DAOCoach();
    $coaches = $daoCoach->obtenerTodos();
    ?>
    <div class="container">
        <h1>Registrar Equipo</h1>
        <form action="procesar_formulario.php" method="post">
            <label for="Equipo">Nombre de Equipo:</label>
            <input type="text" id="Equipo" name="Equipo" required>

            <label for="Estudiante1">Estudiante 1:</label>
            <input type="text" id="Estudiante1" name="Estudiante1" required>

            <label for="Estudiante2">Estudiante 2:</label>
            <input type="text" id="Estudiante2" name="Estudiante2" required>

            <label for="Estudiante3">Estudiante 3:</label>
            <input type="text" id="Estudiante3" name="Estudiante3" required>
            <div>
                <label for="Coach">Coach:</label>
                <select id="Coach" name="Coach" required>
                    <?php
                    // Obtener la lista de coaches desde el DAOCoach
                    // Mostrar las opciones en el select
                    foreach ($coaches as $coach) {
                        echo "<option value='" . $coach->NombreC . "'>" . $coach->NombreC . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="NombreI">Nombre de Institución:</label>
                <select id="NombreI" name="NombreI" required>
                    <?php
                    // Obtener la lista de instituciones desde el DAOCoach
                    $instituciones = $daoCoach->obtenerInstitucion();
                    // Mostrar las opciones en el select
                    foreach ($instituciones as $institucion) {
                        echo "<option value='" . $institucion->NombreI . "'>" . $institucion->NombreI . "</option>";
                    }
                    ?>
                </select>
            </div>
            <label for="foto">Foto:</label>
            <input type="file" id="foto" accept="image/*" required>

            <button type="button" id="submitBtn" onclick="SubmitEvent()">Enviar</button>

            <div class="button-container">
                <input type="submit" value="Registrarse" id="Registrar" class="submit-button">
                <input type="button" value="Regresar" id="Back" class="submit-button" onclick="window.location.href='../Principal/index.php';">
            </div>
        </form>
    </div>
</body>

</html>