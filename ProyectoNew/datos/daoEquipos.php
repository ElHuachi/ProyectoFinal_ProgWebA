<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php';
require_once '../modelos/equipos.php';
require_once '../modelos/instituciones.php';

class DAOEquipos
{
    /**
     * Permite obtener la conexión a la BD
     */
    private $conexion;
    private function conectar()
    {
        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
        }
    }
    public function obtenerTodos(){
        try {
            $this->conectar();

            $lista = array();
            /* Se arma la sentencia SQL para seleccionar todos los registros de la base de datos */
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Equipos");

            // Se ejecuta la sentencia SQL, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /* Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos */
            /* Se recorre el cursor para obtener los datos */
            foreach ($resultado as $row) {
                $obj = new Equipos();

                $obj->IdE = $row->IdE;
                $obj->NombreEquipo = $row->NombreEquipo;
                $obj->Estudiante1 = $row->Estudiante1;
                $obj->Estudiante2 = $row->Estudiante2;
                $obj->Estudiante3 = $row->Estudiante3;
                $obj->Coach = $row->Coach;
                $obj->NombreI = $row->NombreI;

                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }
}
