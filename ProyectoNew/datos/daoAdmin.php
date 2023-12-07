<?php
require_once("conexion.php");
require_once __DIR__ . '/../modelos/admin.php';
class DaoAdmin
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
    public function autenticarAdministrador($usuario, $contrasena)
    {
        try {
            $query = "SELECT idA, idTipo, UsuarioAd FROM Administradores WHERE UsuarioAd = ? AND PassAd = ?";
            $this->conectar();

            // Se prepara la consulta SQL
            $statement = $this->conexion->prepare($query);
            // Se ejecuta la consulta con los parámetros
            $statement->execute([$usuario, $contrasena]);

            // Se obtiene el resultado como un objeto
            $resultado = $statement->fetch(PDO::FETCH_OBJ);

            // Si hay un resultado, se crea un objeto admin
            if ($resultado) {
                $admin = new admin();
                $admin->id = $resultado->idA;
                $admin->idTipo = $resultado->idTipo; // Añade esta línea para obtener idTipo
                $admin->UsuarioAd = $resultado->UsuarioAd;
                return $admin;
            }

            return null;
        } catch (PDOException $e) {
            // Imprime el mensaje de error
            echo "Error en autenticarAdministrador: " . $e->getMessage();
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function insertar($obj)
    {
        try {
            $sql = "INSERT INTO Administradores (idTipo, UsuarioAd, PassAd) VALUES (?, ?, ?)";
            $this->conectar();
            $this->conexion->prepare($sql)->execute([$obj->idTipo, $obj->UsuarioAd, $obj->PassAd]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al insertar: " . $e->getMessage() . ". SQL: $sql");
        } finally {
            Conexion::desconectar();
        }
    }
    public function eliminar($idA)
    {
        try {
            $sql = "DELETE FROM Administradores WHERE idA=?";

            $this->conectar();
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$idA]);

            // Verificar si se eliminó alguna fila
            $rowCount = $stmt->rowCount();

            return $rowCount > 0;
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar: " . $e->getMessage());
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
            $sentenciaSQL = $this->conexion->prepare("SELECT Administradores.idA, Tipo.Nombre AS Tipo, Administradores.UsuarioAd
                                                    FROM Administradores
                                                    JOIN Tipo ON Administradores.idTipo = Tipo.id");

            // Se ejecuta la sentencia SQL, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

            // Se recorre el cursor para obtener los datos
            foreach ($resultado as $row) {
                // Se crea un objeto tipo stdClass para almacenar los datos
                $obj = new stdClass();

                // Se asignan los valores del resultado al objeto
                $obj->idA = $row->idA;
                $obj->Tipo = $row->Tipo;
                $obj->UsuarioAd = $row->UsuarioAd;

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
}
