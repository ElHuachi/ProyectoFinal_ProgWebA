<?php
require_once("conexion.php");
require_once __DIR__ . '/../modelos/auxiliar.php';

class DaoAux
{
    private $conexion;
    private function conectar()
    {
        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            throw new Exception("Error al conectar: " . $e->getMessage());
        }
    }

    public function obtenerTodos()
    {
        try {
            $this->conectar();
            $lista = array();
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM auxiliares");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $row) {
                $auxiliar = new auxiliar();
                $auxiliar->IdAx = $row->IdAx;
                $auxiliar->NombreAx = $row->NombreAx;
                $auxiliar->UsuarioAx = $row->UsuarioAx;
                $auxiliar->PassAx = $row->PassAx;
                $auxiliar->idTipo = $row->idTipo;
                $lista[] = $auxiliar;
            }
            return $resultado;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerTodosPermisos()
    {
        try {
            $this->conectar();

            $lista = array();

            // Se arma la sentencia SQL para seleccionar todos los registros de la base de datos
            $sentenciaSQL = $this->conexion->prepare("SELECT Auxiliares.idAx, Tipo.Nombre AS Tipo, Auxiliares.UsuarioAx
            FROM Auxiliares
            JOIN Tipo ON Auxiliares.idTipo = Tipo.id");

            // Se ejecuta la sentencia SQL, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

            // Se recorre el cursor para obtener los datos
            foreach ($resultado as $row) {
                // Se crea un objeto tipo stdClass para almacenar los datos
                $obj = new stdClass();

                // Se asignan los valores del resultado al objeto
                $obj->idAx = $row->idAx;
                $obj->Tipo = $row->Tipo;
                $obj->UsuarioAx = $row->UsuarioAx;

                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            // Manejo de excepciones, puedes imprimir el mensaje de error o realizar otras acciones según tus necesidades
            echo "Error: " . $e->getMessage();
            return null;
        } finally {
            // Siempre desconecta después de realizar la operación
            Conexion::desconectar();
        }
    }

    public function obtenerUno(){
        try {
            $this->conectar();
            $obj = null;
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM auxiliares WHERE IdAx = ?");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $row) {
                $auxiliar = new auxiliar();
                $auxiliar->IdAx = $row->IdAx;
                $auxiliar->NombreAx = $row->NombreAx;
                $auxiliar->UsuarioAx = $row->UsuarioAx;
                $auxiliar->PassAx = $row->PassAx;
                $auxiliar->idTipo = $row->idTipo;
                $obj = $auxiliar;
            }
            return $obj;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function autenticar(){
        try {
            $this->conectar();
            $obj = null;
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM auxiliares WHERE UsuarioAx = ? AND PassAx = ?");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $row) {
                $auxiliar = new auxiliar();
                $auxiliar->IdAx = $row->IdAx;
                $auxiliar->NombreAx = $row->NombreAx;
                $auxiliar->UsuarioAx = $row->UsuarioAx;
                $auxiliar->PassAx = $row->PassAx;
                $auxiliar->idTipo = $row->idTipo;
                $obj = $auxiliar;
            }
            return $obj;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function eliminar(){
        try {
            $this->conectar();
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM auxiliares WHERE IdAx = ?");
            $sentenciaSQL->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public function update(){
        try {
            $this->conectar();
            $sentenciaSQL = $this->conexion->prepare("UPDATE auxiliares SET NombreAx = ?, UsuarioAx = ?, PassAx = ?, idTipo = ? WHERE IdAx = ?");
            $sentenciaSQL->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public function insertar($obj) {
        try {
            $sql = "INSERT INTO auxiliares (NombreAx, UsuarioAx, PassAx, idTipo) VALUES (?, ?, sha2(?,256), ?)";
            $this->conectar();
            $this->conexion->prepare($sql)->execute([$obj->NombreAx, $obj->UsuarioAx, $obj->PassAx, $obj->idTipo]);
            return true;
        } catch (PDOException $e) {
            return false;
        } finally {
            Conexion::desconectar();
        }
    }
}
