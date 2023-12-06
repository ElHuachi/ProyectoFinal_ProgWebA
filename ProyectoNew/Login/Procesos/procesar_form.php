<?php
// ...
require_once ('../../modelos/equipos.php');
require_once('../../datos/daoEquipos.php');

// Obtener datos del formulario
$equipo = new Equipos();
$equipo->IdE = isset($_POST["idEquipoEditar"]) ? $_POST["idEquipoEditar"] : null;
$equipo->NombreEquipo = $_POST["Equipo"];
$equipo->Estudiante1 = $_POST["Estudiante1"];
$equipo->Estudiante2 = $_POST["Estudiante2"];
$equipo->Estudiante3 = $_POST["Estudiante3"];
$equipo->Coach = $_POST["Coach"];
$equipo->Institucion = $_POST["NombreI"];
$equipo->FotoEquipo = $_POST["FotoEquipo"];

// Verifica si estás editando un equipo
$idEquipoEditar = $equipo->IdE;

try {
    $daoEquipos = new DAOEquipos();

    if ($idEquipoEditar) {
        // Actualiza el equipo existente
        $daoEquipos->actualizar($equipo);
        $message = 'Equipo actualizado correctamente';
    } else {
        // Inserta un nuevo equipo
        $daoEquipos->agregar($equipo);
        $message = 'Equipo registrado correctamente';
    }
} catch (Exception $e) {
    $message = 'Error: ' . $e->getMessage();
}

// Redirige a ListaEquipos con mensaje de confirmación o error
$redirectURL = "/ProyectoNew/Vista/ListaEquipos.php?message=" . urlencode($message);
header("Location: $redirectURL");
exit();
?>
