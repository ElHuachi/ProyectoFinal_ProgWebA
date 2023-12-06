<?php
require('../../datos/daoConcursos.php');

// Verifica si se proporciona el ID del concurso
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $idConcurso = $_GET["id"];
    $daoConcursos = new DAOConcursos();

    // Lógica para eliminar el concurso
    $daoConcursos->eliminar($idConcurso);

    // Después de eliminar, redirigir a la página de concursos con un mensaje
    header("Location: ../listaConcursos.php?message=Concurso eliminado correctamente");
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idConcurso"])) {
    $idConcurso = $_POST["idConcurso"];
    $nombreConcurso = $_POST["nombre"];
    $fechaInicio = $_POST["fechaInicio"];
    $fechaConclusao = $_POST["fechaConclusao"];
    $hora = $_POST["hora"];
    $lugar = $_POST["lugar"];

    // Actualiza los datos del concurso
    $concurso = new Concursos();
    $concurso->IdC = $idConcurso;
    $concurso->NombreC = $nombreConcurso;
    $concurso->FechaI = $fechaInicio;
    $concurso->FechaC = $fechaConclusao;
    $concurso->HoraC = $hora;
    $concurso->LugarC = $lugar;

    // Guarda los cambios en la base de datos
    $daoConcursos = new DAOConcursos();
    $daoConcursos->actualizar($concurso);

    // Redirige a la página de concursos con un mensaje
    header("Location: ../listaConcursos.php?message=Concurso editado correctamente");
    exit();
} else {
    // Manejar el caso en que no se proporcionaron datos suficientes
    header("Location: ../listaConcursos.php?error=Datos insuficientes para la acción");
    exit();
}
?>
