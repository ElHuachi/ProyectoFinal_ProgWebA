<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de registro de equipos para coding cup</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="../dt/DataTables-1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../dt/Buttons-2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="icon" href="/favicon.ico">
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION["tipo_usuario"]) || ($_SESSION["tipo_usuario"] !== 'coach' && $_SESSION["tipo_usuario"] !== 'auxiliar') && $_SESSION["tipo_usuario"] !== 'administrador') {
        header("Location: /ProyectoNew/Login/Login.php");
        exit();
    }

    require('../Principal/menu.php');
    require_once('../Datos/daoEquipos.php');
    $nombreCoach = $_SESSION['usuario_nombre'];
    $dao = new DAOEquipos();
    if (isset($_SESSION['tipo_usuario']) && ($_SESSION['tipo_usuario'] === 'administrador' || $_SESSION['tipo_usuario'] === 'auxiliar')) {
        $listaEquipos = $dao->obtenerTodos();
    } else {
        $listaEquipos = $dao->obtenerEquiposPorCoach($nombreCoach);
    }
    ?>
    <div class="container">
        <table id="lista" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Integrantes</th>
                    <th>Coach</th>
                    <th>Institución</th>
                    <th>Aprobado</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($listaEquipos) {
                    foreach ($listaEquipos as $equipo) {
                        echo "<tr>",
                        "<td>{$equipo->NombreEquipo}</td>",
                        "<td>{$equipo->Estudiante1}<br>{$equipo->Estudiante2}<br>{$equipo->Estudiante3}</td>",
                        "<td>{$equipo->Coach}</td>",
                        "<td>{$equipo->Institucion}</td>",
                        "<td>{$equipo->Aprobado}</td>",
                        "<td>";
                        // Botón de autorizar solo para administrador y auxiliar
                        if (isset($_SESSION['tipo_usuario']) && ($_SESSION['tipo_usuario'] === 'administrador' || $_SESSION['tipo_usuario'] === 'auxiliar')) {
                            // Verifica si el equipo está aprobado
                            if ($equipo->Aprobado != 1) {
                                echo "<button class='btn btn-success btn-autorizar' id='btn-Autorizar-{$equipo->IdE}' data-idE='{$equipo->IdE}' data-equipo='{$equipo->NombreEquipo}'>Autorizar</button>",
                                "<button class='btn btn-primary btn-editar' data-idE='{$equipo->IdE}'>Editar</button>";
                            } else {
                                echo "<button class='btn btn-danger btn-eliminar' id='btn-Eliminar-{$equipo->IdE}' data-idE='{$equipo->IdE}' data-equipo='{$equipo->NombreEquipo}'>Eliminar</button>";
                            }
                        } elseif ($equipo->Aprobado != 1) {
                            // Botón de editar solo para coach
                            echo "<button class='btn btn-primary btn-editar' data-idE='{$equipo->IdE}'>Editar</button>";
                        }
                        echo "</td>",
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
    <script src="../Vista/Js/ListaEquipos.js"></script>
</body>

</html>