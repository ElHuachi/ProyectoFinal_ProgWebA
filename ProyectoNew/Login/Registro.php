<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Coach</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link rel="icon" href="https://lh6.googleusercontent.com/DQqOseiOF2DibeQSu3EApJu3EE7j7JIVBEiJqEcLE1ScAIBUdYfRki5lDMPRYkuTQ8VdKHnmJ6GMV9gW7y17X5AbHYBfG9e8eT-WT2q13BgJ0HiW">
</head>
<body>
    <div class="container">
        <h1>Registro de Coach</h1>
        <form action="procesar_registro.php" method="post" class="login-form">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="correo">Correo (Usuario):</label>
            <input type="email" id="correo" name="correo" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <label for="institucion">Institución:</label>
            <input type="text" id="institucion" name="institucion" required>
            <div class="button-container">
                <input type="submit" value="Registrarse" id="Registrar" class="submit-button">
                <input type="button" value="Regresar" id="Back" class="submit-button" onclick="window.location.href='../Principal/index.php';">
            </div>
        </form>
    </div>
</body>
</html>
