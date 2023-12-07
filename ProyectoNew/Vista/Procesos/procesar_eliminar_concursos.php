<?php
require('../../datos/daoConcursos.php');
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $idConcurso = $_GET["id"];
    $daoConcursos = new DAOConcursos();
    $daoConcursos->eliminar($idConcurso);
    header("Location: ../listaConcursos.php?message=Concurso eliminado correctamente");
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idConcurso"])) {
    $idConcurso = $_POST["idConcurso"];
    $nombreConcurso = $_POST["nombre"];
    $fechaInicio = $_POST["fechaInicio"];
    $fechaConclusao = $_POST["fechaConclusao"];
    $hora = $_POST["hora"];
    $lugar = $_POST["lugar"];
    $concurso = new Concursos();
    $concurso->IdC = $idConcurso;
    $concurso->NombreC = $nombreConcurso;
    $concurso->FechaI = $fechaInicio;
    $concurso->FechaC = $fechaConclusao;
    $concurso->HoraC = $hora;
    $concurso->LugarC = $lugar;
    $daoConcursos = new DAOConcursos();
    $daoConcursos->actualizar($concurso);
    header("Location: ../listaConcursos.php?message=Concurso editado correctamente");
    exit();
} else {
    header("Location: ../listaConcursos.php?error=Datos insuficientes para la acción");
    exit();
}
?>
