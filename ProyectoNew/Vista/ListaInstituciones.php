<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de administración de Instituciones</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="../dt/DataTables-1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../dt/Buttons-2.4.2/css/buttons.bootstrap5.min.css">
</head>

<body>
  <?php
  require('../Principal/menu.php');
  require_once('../datos/DAOCoach.php');
  $dao = new DAOCoach();
  $instituciones = $dao->obtenerInstitucion();
  ?>
  <div class="container">
    <table id="lista" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Instituciones</th>
          <th>Operaciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($instituciones as $institucion) {
          echo "<tr>",
          "<td>" . $institucion->NombreI . "</td>",
          "<td>",
          "<button class='btn btn-danger btn-eliminar' data-NombreI='{$institucion->NombreI}'>Eliminar</button>",
          "</td>",
          "</tr>";
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
          <button type="button" class="btn btn-danger" id="btnConfirmar" onclick="confirmarEliminar()">Si, continuar con la eliminación</button>
        </div>
      </div>
    </div>
  </div>

  <script src="../Vista/Js/bootstrap.bundle.min.js"></script>
  <script src="../dt/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
  <script src="../Vista/Js/ListaInstituciones.js"></script>
</body>

</html>