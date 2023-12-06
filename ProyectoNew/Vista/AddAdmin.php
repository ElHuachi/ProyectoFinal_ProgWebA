<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro de Admin/Aux</title>
</head>

<body>
    <?php
    require('../Principal/menu.php');
    require_once('../datos/daoAdmin.php');
    require_once('../datos/daoAux.php');
    ?>

    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="confirmationMessage">Usuario <span id="userName"></span> Registrado con éxito</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="registerUserInDB()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <form id="registroForm" action="../Vista/Procesos/procesar_registro.php" method="post">
        <label for="tipo_usuario">Selecciona el tipo de usuario:</label>
        <select name="tipo_usuario" id="tipo_usuario" onchange="handleTipoUsuarioChange()">
            <option value="admin">Administrador</option>
            <option value="auxiliar">Auxiliar</option>
        </select>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <div id="admin_fields" style="display: none;">
        </div>
        <div id="auxiliar_fields" style="display: none;">
            <label for="nombre_auxiliar">Nombre del Auxiliar:</label>
            <input type="text" name="nombre_auxiliar" id="nombre_auxiliar">
        </div>
        <input type="button" value="Registrar" onclick="validateAndSubmit()">
    </form>

    <script src="../dt/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
    <script src="../Vista/Js/bootstrap.bundle.min.js"></script>
    <script src="../Vista/Js/ListaUsuarios.js"></script>
</body>

</html>
