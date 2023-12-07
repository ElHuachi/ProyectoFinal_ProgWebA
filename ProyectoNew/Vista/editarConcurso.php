<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Concurso</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
<?php
    require('../Principal/menu.php');
    require('../datos/conexion.php');
    require('../datos/daoConcursos.php');

    // Verifica si se proporciona el ID del concurso a editar
    if (isset($_GET["IdC"])) {
        $idConcurso = $_GET["IdC"];

        // Obtiene los datos del concurso
        $daoConcursos = new DAOConcursos();
        $concurso = $daoConcursos->obtenerPorId($idConcurso);

        if (!$concurso) {
            echo "Concurso no encontrado.";
            exit();
        }
    } else {
        echo "ID de concurso no proporcionado.";
        exit();
    }
    ?>

    <div class="container mt-4">
        <h2>Editar Concurso</h2>

        <form action="Procesos/procesar_eliminar_concursos.php" method="post">
            <input type="hidden" name="idConcurso" value="<?php echo $concurso->IdC; ?>">

            <div class="mb-3">
                <label for="nombre">Nombre del Concurso</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $concurso->NombreC; ?>" required>
            </div>

            <div class="mb-3">
                <label for="fechaInicio">Fecha de Inscripcion</label>
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo $concurso->FechaI; ?>" required>
            </div>

            <div class="mb-3">
                <label for="fechaConclusao">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fechaConclusao" name="fechaConclusao" value="<?php echo $concurso->FechaC; ?>" required>
            </div>

            <div class="mb-3">
                <label for="hora">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $concurso->HoraC; ?>" required>
            </div>

            <div class="mb-3">
                <label for="lugar">Lugar</label>
                <input type="text" class="form-control" id="lugar" name="lugar" value="<?php echo $concurso->LugarC; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
