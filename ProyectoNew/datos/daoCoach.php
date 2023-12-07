<?php
//importa la clase conexión y los modelos para usarlos
require_once('conexion.php');
require_once __DIR__ . '/../modelos/coach.php';
require_once __DIR__ . '/../modelos/equipos.php';
require_once __DIR__ . '/../modelos/instituciones.php';

class DAOCoach
{
    private $conexion;

    private function conectar()
    {
        if (session_status()) {
        }

        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function obtenerTodos()
    {
        try {
            $this->conectar();

            $lista = array();
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Coach");
            $sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $row) {
                $obj = new Coach();

                $obj->IdC = $row->IdC;
                $obj->NombreC = $row->NombreC;
                $obj->CorreoC = $row->CorreoC;
                $obj->Institucion = $row->Institucion;
                $obj->idTipo = $row->idTipo;
                $obj->PassCo = $row->PassCo;

                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerInstitucion()
    {
        try {
            $this->conectar();
            $lista = array();
            $sentenciaSQL = $this->conexion->prepare("SELECT NombreI FROM Instituciones");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $row) {
                $obj = new Instituciones();
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

    public function eliminarInstitucion($nombre)
    {
        try {
            $this->conectar();
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM Instituciones WHERE NombreI = ?");
            $sentenciaSQL->execute([$nombre]);
            return true;
        } catch (PDOException $e) {
            return false;
        } finally {
            Conexion::desconectar();
        }
    }
    public function autenticarCoach($correo, $contrasena)
{
    try {
        $this->conectar();
        $usuario = null;
        $sentenciaSQL = $this->conexion->prepare("SELECT IdC, NombreC FROM Coach WHERE CorreoC=? AND PassCo=?");
        $sentenciaSQL->execute(array($correo, $contrasena));
        $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
        if ($resultado) {
            $usuario = new Coach();
            $usuario->IdC = $resultado->IdC;
            $usuario->NombreC = $resultado->NombreC;
        }
        return $usuario;
    } catch (Exception $e) {
        return null;
    } finally {
        Conexion::desconectar();
    }
}
    public function eliminar($IdC)
    {
        try {
            $this->conectar();
            $sql = "DELETE FROM Coach WHERE IdC = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$IdC]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar: " . $e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }
    public function insertarCoach($coach)
    {
        try {
            $sql = "INSERT INTO Coach (NombreC, CorreoC, Institucion, idTipo, PassCo) VALUES (?, ?, ?, ?, ?)";
            $this->conectar();
            $this->conexion->prepare($sql)->execute([$coach->NombreC,$coach->CorreoC,$coach->Institucion,$coach->idTipo,$coach->PassCo]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al insertar: " . $e->getMessage() . ". SQL: $sql");
        } finally {
            Conexion::desconectar();
        }
    }
}
