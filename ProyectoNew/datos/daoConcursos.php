<?php
require_once('conexion.php');
require_once __DIR__ . '/../modelos/concursos.php';

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
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Concursos");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $row) {
                $obj = new Concursos();
                $obj->IdC = $row->IdC;
                $obj->NombreC = $row->NombreC;
                $obj->FechaI = $row->FechaI;
                $obj->FechaC = $row->FechaC;
                $obj->HoraC = $row->HoraC;
                $obj->LugarC = $row->LugarC;
                $lista[] = $obj;
            }
            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerPorId($id)
    {
        try {
            $this->conectar();

            $sql = "SELECT * FROM Concursos WHERE IdC = ?";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([$id]);

            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            if (!$resultado) {
                return null; // Si no se encuentra el concurso con el ID proporcionado
            }

            $concurso = new Concursos();
            $concurso->IdC = $resultado->IdC;
            $concurso->NombreC = $resultado->NombreC;
            $concurso->FechaI = $resultado->FechaI;
            $concurso->FechaC = $resultado->FechaC;
            $concurso->HoraC = $resultado->HoraC;
            $concurso->LugarC = $resultado->LugarC;

            return $concurso;
        } catch (PDOException $e) {
            return null; // Manejo de errores
        } finally {
            Conexion::desconectar();
        }
    }
    public function eliminar($id)
    {
        try {
            $this->conectar();
            $sql = "DELETE FROM Concursos WHERE IdC = ?";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([$id]);
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }

    public function actualizar($obj)
    {
        try {
            $sql = "UPDATE Concursos SET NombreC = ?, FechaI = ?, FechaC = ?, HoraC = ?, LugarC = ? WHERE IdC = ?";
            $this->conectar();
            $this->conexion->prepare($sql)->execute(
                array(
                    $obj->NombreC,
                    $obj->FechaI,
                    $obj->FechaC,
                    $obj->HoraC,
                    $obj->LugarC,
                    $obj->IdC
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }
}
