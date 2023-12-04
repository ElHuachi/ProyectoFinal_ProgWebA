<?php
require_once("../datos/Conexion.php");
require_once("../modelos/admin.php");
class DaoAdmin
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
    public function login($username, $password)
    {
        try {
            $this->conectar();
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM admin WHERE UsuarioAd=? AND PassAd=?");
            $sentenciaSQL->execute([$username, $password]);
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            if ($resultado) {
                return $resultado;
            } else {
                return null;
            }
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
            $sql = "INSERT INTO admin(idTipo,UsuarioAd,PassAd) values(?,?,?)";

            $this->conectar();
            $this->conexion->prepare($sql)->execute(
                array(
                    $obj->idTipo,
                    $obj->UsuarioAd,
                    $obj->PassAd
                )
            );
            return true;
        } catch (PDOException $e) {
            return false;
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
            $sql = "UPDATE admin SET idTipo=?,UsuarioAd=?,PassAd=? WHERE id=?";

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
    public function eliminar($id)
    {
        try {
            $sql = "DELETE FROM admin WHERE id=?";

            $this->conectar();
            $this->conexion->prepare($sql)->execute(array($id));
            return true;
        } catch (PDOException $e) {
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerTipoPermisos(){
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

    public function obtenerTodosPermisos(){
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
