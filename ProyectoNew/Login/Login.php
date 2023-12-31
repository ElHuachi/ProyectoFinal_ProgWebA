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
    // require __DIR__ . '../Login/Procesos/proceso_inicio.php';
    // require('../Principal/menu.php');
    // echo "Tipo de Usuario: " . $_SESSION["tipo_usuario"];
    ?>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <form method="post" action="/ProyectoNew/Login/Procesos/proceso_inicio.php" class="login-form">
            <label for="tipo_usuario">Tipo de Usuario:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
                <option value="coach">Coach</option>
                <option value="administrador">Administrador</option>
                <option value="auxiliar">Auxiliar</option>
            </select>
            <label for="correo">Correo:</label>
            <input type="text" id="correo" name="correo" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena"  required>
            <div class="button-container">
                <input type="submit" value="Iniciar Sesión" id="iniciobtn" class="submit-button">
                <input type="button" value="Regresar" id="back" class="submit-button" onclick="window.location.href='../Principal/index.php';">
            </div>
        </form>

        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p>Error: Usuario Y/O Contraseña incorrecto</p>";
        } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
            echo "<p>Error: No se recibieron datos por POST</p>";
        }
        ?>
    </div>
</body>
<!-- <script src="JS/validacion_login.js"></script> -->
</html>
