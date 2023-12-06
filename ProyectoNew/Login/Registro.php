<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Coach</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <?php
    require_once("../datos/daoCoach.php");
    // require('../Principal/menu.php');
    $daoCoach = new DAOCoach();
    ?>
    <div class="container">
        <h1>Registro de Coach</h1>
        <form action="Procesos/proceso_registro.php" method="post" class="login-form">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="correo">Correo (Usuario):</label>
            <input type="email" id="correo" name="correo" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
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
            <div class="button-container">
                <input type="submit" value="Registrarse" id="Registrar" class="submit-button">
                <input type="button" value="Regresar" id="Back" class="submit-button" onclick="window.location.href='../Principal/index.php';">
            </div>
        </form>
    </div>
</body>
</html>
