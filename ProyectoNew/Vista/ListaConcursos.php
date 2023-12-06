<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de administración de Concursos</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="../dt/DataTables-1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../dt/Buttons-2.4.2/css/buttons.bootstrap5.min.css">
</head>

<body>
    <?php
    require('../Principal/menu.php');
    require('../datos/conexion.php');
    require('../datos/daoConcursos.php');
    $daoConcursos = new DAOConcursos();
    $concursos = $daoConcursos->obtenerTodos();
    ?>
<div class="container">
        <table id="lista" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Concurso</th>
                    <th>Fecha de Inscripción</th>
                    <th>Fecha de Inicio</th>
                    <th>Hora</th>
                    <th>Lugar</th>
                    <th>Operaciones</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($concursos) {
                    foreach ($concursos as $concurso) {
                        echo "<tr><td>{$concurso->NombreC}</td>",
                        "<td>{$concurso->FechaI}</td>",
                        "<td>{$concurso->FechaC}</td>",
                        "<td>{$concurso->HoraC}</td>",
                        "<td>{$concurso->LugarC}</td>",
                        "<td>",
                        "<button class='btn btn-danger btn-eliminar' data-idc='{$concurso->IdC}' data-nombre='{$concurso->NombreC}'>Eliminar</button>",
                        "<button class='btn btn-primary btn-editar' data-idc='{$concurso->IdC}'>Editar</button>",
                        "</td>",
                        "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron registros</td></tr>";
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
                    <p>Está a punto de eliminar a <strong id="spnPersona"></strong>. ¿Desea continuar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-confirmar" id="btn-Confirmar">Sí, continuar con la eliminación</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../Vista/Js/bootstrap.bundle.min.js"></script>
    <script src="../dt/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
    <script src="../dt/DataTables-1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../dt/DataTables-1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="../dt/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="../dt/Buttons-2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="../dt/JSZip-3.10.1/jszip.min.js"></script>
    <script src="../dt/pdfmake-0.2.7/pdfmake.min.js"></script>
    <script src="../dt/pdfmake-0.2.7/vfs_fonts.js"></script>
    <script src="../dt/Buttons-2.4.2/js/buttons.html5.min.js"></script>
    <script src="../dt/Buttons-2.4.2/js/buttons.print.min.js"></script>
    <script src="../dt/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
    <script src="../Vista/Js/ListaConcursos.js"></script>
</body>

</html>
