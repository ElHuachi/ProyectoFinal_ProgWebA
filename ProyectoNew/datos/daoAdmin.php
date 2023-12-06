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
            $query = "SELECT id, UsuarioAd FROM Administrador WHERE UsuarioAd = ? AND PassAd = SHA2(?, 224)";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(1, $usuario);
            $statement->bindParam(2, $contrasena);
            $statement->execute();

            $resultado = $statement->fetch(PDO::FETCH_OBJ);

            if ($resultado) {
                $admin = new admin();
                $admin->id = $resultado->id;
                $admin->UsuarioAd = $resultado->UsuarioAd;
                return $admin;
            }

            return null;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }


    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: ../index.php");
    }
    /**
     * Metodo que permite insertar un nuevo registro en la tabla
     * de usuarios
     */
    public function insertar($obj)
    {
        try {
            $sql = "INSERT INTO Administradores (idTipo, UsuarioAd, PassAd) VALUES (?, ?, sha2(?,256))";
            $this->conectar();
            $this->conexion->prepare($sql)->execute([$obj->idTipo, $obj->UsuarioAd, $obj->PassAd]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al insertar: " . $e->getMessage() . ". SQL: $sql");
        } finally {
            Conexion::desconectar();
        }
    }
    /**
     * Metodo que permite actualizar un registro en la tabla
     * de usuarios
     */
    public function update($id, $obj)
    {
        try {
            $sql = "UPDATE Administradores SET idTipo=?,UsuarioAd=?,PassAd=? WHERE id=?";

            $this->conectar();
            $this->conexion->prepare($sql)->execute(
                array(
                    $obj->idTipo,
                    $obj->UsuarioAd,
                    $obj->PassAd,
                    $id
                )
            );
            return true;
        } catch (PDOException $e) {
            return false;
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


    public function obtenerTipoPermisos()
    {
        try {
            $this->conectar();

            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Tipo");

            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
            foreach ($resultado as $row) {
                $obj = new Tipo();

                $obj->id = $row->id;
                $obj->Nombre = $row->Nombre;

                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }
    public function obtenerTodos()
    {
        try {
            $this->conectar();

            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Administradores");

            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
            foreach ($resultado as $row) {
                $obj = new admin();

                $obj->id = $row->id;
                $obj->idTipo = $row->idTipo;
                $obj->UsuarioAd = $row->UsuarioAd;
                $obj->PassAd = $row->PassAd;

                $lista[] = $obj;
            }

            return $lista;
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

    public function obtenerUno()
    {
        try {
            $this->conectar();

            $obj = null;

            // Se arma la sentencia SQL para seleccionar todos los registros de la base de datos
            $sentenciaSQL = $this->conexion->prepare("SELECT Administradores.idA, Tipo.Nombre AS Tipo, Administradores.UsuarioAd
                                                    FROM Administradores
                                                    JOIN Tipo ON Administradores.idTipo = Tipo.id
                                                    WHERE Administradores.idA = ?");

            // Se ejecuta la sentencia SQL, retorna un cursor con todos los elementos
            $sentenciaSQL->execute(array($_SESSION["idA"]));

            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            // Se recorre el cursor para obtener los datos
            if ($resultado) {
                // Se crea un objeto tipo stdClass para almacenar los datos
                $obj = new stdClass();

                // Se asignan los valores del resultado al objeto
                $obj->idA = $resultado->idA;
                $obj->Tipo = $resultado->Tipo;
                $obj->UsuarioAd = $resultado->UsuarioAd;
            }

            return $obj;
        } catch (PDOException $e) {
            // Manejo de excepciones, puedes imprimir el mensaje de error o realizar otras acciones según tus necesidades
            echo "Error: " . $e->getMessage();
            return null;
        } finally {
            // Siempre desconecta después de realizar la operación
            Conexion::desconectar();
        }
    }

    public function autenticar()
    {
        try {
            $this->conectar();

            $obj = null;

            // Se arma la sentencia SQL para seleccionar todos los registros de la base de datos
            $sentenciaSQL = $this->conexion->prepare("SELECT Administradores.idA, Tipo.Nombre AS Tipo, Administradores.UsuarioAd
                                                    FROM Administradores
                                                    JOIN Tipo ON Administradores.idTipo = Tipo.id
                                                    WHERE Administradores.idA = ?");

            // Se ejecuta la sentencia SQL, retorna un cursor con todos los elementos
            $sentenciaSQL->execute(array($_SESSION["idA"]));

            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            // Se recorre el cursor para obtener los datos
            if ($resultado) {
                // Se crea un objeto tipo stdClass para almacenar los datos
                $obj = new stdClass();

                // Se asignan los valores del resultado al objeto
                $obj->idA = $resultado->idA;
                $obj->Tipo = $resultado->Tipo;
                $obj->UsuarioAd = $resultado->UsuarioAd;
            }

            return $obj;
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
