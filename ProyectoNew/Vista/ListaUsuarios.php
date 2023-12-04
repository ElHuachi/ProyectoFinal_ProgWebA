<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de administracion de usuarios</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="dt/DataTables-1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="dt/Buttons-2.4.2/css/buttons.bootstrap5.min.css">

  <style>
    .btn-verde {
      background-color: rgb(8, 218, 148) !important;
    }
  </style>
</head>

<body>
  <?php
  require('../Principal/menu.php');
  /* require_once('../datos/daoUsuario.php');
  $dao = new DAOUsuario();
  $ListaUsuarios = $dao->obtenerTodos();  */
  ?>
  <div class="container">
    <a class="btn btn-success mt-5 mb-3" href="usuario.php">Agregar</a>
    <table id="lista" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Coach</th>
          <th>Institución</th>
          <th>Equipo</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($listaUsuarios as $usuario) {
          echo "<tr><td>" . trim($usuario->apellido1 . " " . $usuario->apellido2) . " " . $usuario->nombre . "</td>" .
            "<td>" . $usuario->email . "</td>" .
            "<td>" . ($usuario->genero == "M" ? "Masculino" : "Femenino") . "</td>" .
            "<td>" .
            "<button type='button' class='btn btn-primary btn-editar' data-id='" . $usuario->id . "'>Editar</button>" .
            "<button type='button' class='btn btn-danger btn-eliminar' onclick='confirmar(this)' data-id='" . $usuario->id . "'>Eliminar</button>" .
            "</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="modal" id="mdlConfirmacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Está a punto de eliminar a <strong id="spnPersona"></strong>
            ¿Desea continuar?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btnConfirmar" onclick="confirmarEliminar()">Si, continuar con la eliminación</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal" id="mdlInformacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Catálogo de personas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          El registro ha sido eliminado
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCerrar">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="dt/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
  <script src="dt/DataTables-1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="dt/DataTables-1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="dt/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="dt/Buttons-2.4.2/js/buttons.bootstrap5.min.js"></script>
  <script src="dt/JSZip-3.10.1/jszip.min.js"></script>
  <script src="dt/pdfmake-0.2.7/pdfmake.min.js"></script>
  <script src="dt/pdfmake-0.2.7/vfs_fonts.js"></script>
  <script src="dt/Buttons-2.4.2/js/buttons.html5.min.js"></script>
  <script src="dt/Buttons-2.4.2/js/buttons.print.min.js"></script>
  <script src="dt/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
  <script src="Js/ListaUsuarios.js"></script>
</body>

</html>