<?php

require_once('conexion.php');
require_once __DIR__ . '/../modelos/equipos.php';
require_once __DIR__ . '/../modelos/instituciones.php';

class DAOEquipos
{
    private $conexion;

    private function conectar()
    {
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
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Equipos");

            $sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

            foreach ($resultado as $row) {
                $obj = new Equipos();
                $obj->IdE = $row->IdE;
                $obj->NombreEquipo = $row->NombreEquipo;
                $obj->Estudiante1 = $row->Estudiante1;
                $obj->Estudiante2 = $row->Estudiante2;
                $obj->Estudiante3 = $row->Estudiante3;
                $obj->Coach = $row->Coach;
                $obj->Institucion = $row->Institucion;
                $obj->FotoEquipo = $row->FotoEquipo;
                $obj->Aprobado = $row->Aprobado;
                $lista[] = $obj;
            }
            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function agregar($obj)
    {
        try {
            $sql = "INSERT INTO Equipos (NombreEquipo, Estudiante1, Estudiante2, Estudiante3, Coach, Institucion, FotoEquipo, Aprobado) values(?,?,?,?,?,?,?,?)";
            $this->conectar();
            $this->conexion->prepare($sql)->execute(
                array(
                    $obj->NombreEquipo,
                    $obj->Estudiante1,
                    $obj->Estudiante2,
                    $obj->Estudiante3,
                    $obj->Coach,
                    $obj->Institucion,
                    $obj->FotoEquipo,
                    $obj->Aprobado
                )
            );
            // Redirige a la página de ListaEquipos después de agregar
            header("Location: /ProyectoNew/Vista/ListaEquipos.php");
            exit();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            Conexion::desconectar();
        }
    }

    public function eliminar($id)
    {
        try {
            $this->conectar();
            $sql = "DELETE FROM Equipos WHERE IdE = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$id]);
            // Redirige a la página de ListaEquipos después de eliminar
            header("Location: /ProyectoNew/Vista/ListaEquipos.php");
            exit();
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar: " . $e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }

    public function autorizar($idE)
    {
        try {
            $this->conectar();
            $sql = "UPDATE Equipos SET Aprobado = 1 WHERE IdE = ?";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([$idE]);

            // Redirige a la página de ListaEquipos después de autorizar
            header("Location: /ProyectoNew/Vista/ListaEquipos.php");
            exit();
        } catch (PDOException $e) {
            throw new Exception("Error al autorizar: " . $e->getMessage());
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerUno($id)
    {
        try {
            $this->conectar();
            $obj = null;
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Equipos WHERE IdE = ?");
            $sentenciaSQL->execute(array($id));
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $row) {
                $obj = new Equipos();

                $obj->IdE = $row->IdE;
                $obj->NombreEquipo = $row->NombreEquipo;
                $obj->Estudiante1 = $row->Estudiante1;
                $obj->Estudiante2 = $row->Estudiante2;
                $obj->Estudiante3 = $row->Estudiante3;
                $obj->Coach = $row->Coach;
                $obj->Institucion = $row->Institucion;
                $obj->FotoEquipo = $row->FotoEquipo;
                $obj->Aprobado = $row->Aprobado;
            }
            return $obj;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function actualizar($obj)
    {
        try {
            $sql = "UPDATE Equipos SET NombreEquipo=?, Estudiante1=?, Estudiante2=?, Estudiante3=?, Coach=?, Institucion=?, FotoEquipo=?, Aprobado=? WHERE IdE=?";
            $this->conectar();
            $this->conexion->prepare($sql)->execute(
                array(
                    $obj->NombreEquipo,
                    $obj->Estudiante1,
                    $obj->Estudiante2,
                    $obj->Estudiante3,
                    $obj->Coach,
                    $obj->Institucion,
                    $obj->FotoEquipo,
                    $obj->Aprobado,
                    $obj->IdE
                )
            );
            // Redirige a la página de ListaEquipos después de actualizar
            header("Location: /ProyectoNew/Vista/ListaEquipos.php");
            exit();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerEquiposPorCoach($nombreCoach)
    {
        try {
            $this->conectar();

            $listaEquipos = array();

            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Equipos WHERE Coach = ?");
            $sentenciaSQL->execute(array($nombreCoach));

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

            foreach ($resultado as $row) {
                $equipo = new Equipos();

                $equipo->IdE = $row->IdE;
                $equipo->NombreEquipo = $row->NombreEquipo;
                $equipo->Estudiante1 = $row->Estudiante1;
                $equipo->Estudiante2 = $row->Estudiante2;
                $equipo->Estudiante3 = $row->Estudiante3;
                $equipo->Coach = $row->Coach;
                $equipo->Institucion = $row->Institucion;
                $equipo->Aprobado = $row->Aprobado;

                $listaEquipos[] = $equipo;
            }

            return $listaEquipos;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }
}
