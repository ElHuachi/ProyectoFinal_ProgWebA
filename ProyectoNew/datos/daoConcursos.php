<?php
require_once 'conexion.php';
require_once '../modelos/concursos.php';

class DAOConcursos
{
    private $conexion;
    private function conectar()
    {
        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
        }
    }

    public function obtenerTodos()
    {
        try {
            $this->conectar();

            $lista = array();
            /* Se arma la sentencia SQL para seleccionar todos los registros de la base de datos */
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Concursos");

            // Se ejecuta la sentencia SQL, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /* Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos */
            /* Se recorre el cursor para obtener los datos */
            foreach ($resultado as $row) {
                $obj = new Concursos();
                $obj->NombreC = $row->NombreC;
                $obj->FechaC = $row->FechaC;
                $obj->HoraC = $row->HoraC;
                $obj->LugarC = $row->LugarC;
                $obj->Institucion = $row->Institucion;
                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerUno()
    {
        try {
            $this->conectar();
            $sql = "SELECT * FROM Concursos WHERE NombreC = ?";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            $obj = new Concursos();
            $obj->NombreC = $resultado->NombreC;
            $obj->FechaC = $resultado->FechaC;
            $obj->HoraC = $resultado->HoraC;
            $obj->LugarC = $resultado->LugarC;
            $obj->Institucion = $resultado->Institucion;
            return $obj;
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }

    public function agregar($obj)
    {
        try {
            $sql = "INSERT INTO Concursos (NombreC, FechaC, HoraC, LugarC, Institucion) values(?,?,?,?,?)";
            $this->conectar();
            $this->conexion->prepare($sql)->execute(
                array(
                    $obj->NombreC,
                    $obj->FechaC,
                    $obj->HoraC,
                    $obj->LugarC,
                    $obj->Institucion
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }

    public function eliminar($id)
    {
        try {
            $this->conectar();
            $sql = "DELETE FROM Concursos WHERE NombreC = ?";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }

    public function actualizar($obj)
    {
        try {
            $sql = "UPDATE Concursos SET NombreC = ?, FechaC = ?, HoraC = ?, LugarC = ?, Institucion = ? WHERE NombreC = ?";
            $this->conectar();
            $this->conexion->prepare($sql)->execute(
                array(
                    $obj->NombreC,
                    $obj->FechaC,
                    $obj->HoraC,
                    $obj->LugarC,
                    $obj->Institucion
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }
}
