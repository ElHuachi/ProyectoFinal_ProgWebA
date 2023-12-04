<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de administracion de Concursos</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="dt/DataTables-1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="dt/Buttons-2.4.2/css/buttons.bootstrap5.min.css">
  <link rel="icon" href="https://lh5.googleusercontent.com/TZGZLyLItpVbRjj8C-y7iwKn9F7-nJSgyS3vjtNJBM3LG2Dqr9xKYafZc-alHwjoUkx_98mEEoLddVv3Oq73Bb6udZgeJ-u5dW34RFYe157wU4J_">
  <style>
    .btn-verde {
      background-color: rgb(8, 218, 148) !important;
    }
  </style>
</head>

<body>
  <?php
  require('../Principal/menu.php');
  require('../datos/daoAdmin.php');
  session_start();
  $daoAdmin = new DaoAdmin();
  $data = $daoAdmin->obtenerTodosPermisos();
  ?>
  <div class="container">
    <a class="btn btn-success mt-5 mb-3" href="usuario.php">Agregar</a>
    <table id="lista" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Id</th>
          <th>Usuario</th>
          <th>Tipo de permisos</th>
          <th>Operaciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($data) {
          foreach ($data as $value) {
              echo "<tr><td>" . $value->idA . "</td>",
                  "<td>" . $value->UsuarioAd . "</td>",
                  "<td>" . $value->Tipo . "</td>",
                  "<td>",
                  "<button class='btn btn-danger btn-eliminar' onclick='confirmar(" . $value->idA . ",\"" . $value->UsuarioAd . "\")'>Eliminar</button>",
                  "</td>",
                  "</tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No se encontraron registros</td></tr>";
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
    <script src="../Vista/Js/ListaAdmins.js"></script>
</body>
</html>