<?php
require_once 'conexion.php';
require_once '../modelos/usuario.php';

class DAOUsuario
{

    private $conexion;

    /**
     * Permite obtener la conexión a la BD
     */
    private function conectar()
    {
        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
        }
    }

    public function autenticar($correo, $password)
    {
        try {
            $this->conectar();
            $obj = null;
            $sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,apellido1,apellido2 FROM usuarios WHERE email=? AND password=?");
            $sentenciaSQL->execute(array($correo, $password));
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            if ($fila) {
                $obj = new Usuario();
                $obj->id = $fila->id;
                $obj->nombre = $fila->nombre;
                $obj->apellido1 = $fila->apellido1;
                $obj->apellido2 = $fila->apellido2;
                return $obj;
            }
            return null;
        } catch (Exception $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }
    function calcularEdad($fechaNac)
    {
        $h = new DateTime();
        return $h->diff($fechaNac)->y;
    }

    /**
     * Función para editar al empleado de acuerdo al objeto recibido como parámetro
     */
    public function editar(Usuario $obj)
    {
        try {
            $sql = "UPDATE usuarios
                    SET
                    nombre = ?,
                    apellido1 = ?,
                    apellido2 = ?,
                    email = ?,
                    fechaNac = ?,
                    edad = ?,
                    genero = ?,
                    intereses = ?,
                    estadoCivil = ?,
                    password = sha2(?,224)
                    WHERE id = ?;";

            $this->conectar();

            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute(
                array(
                    $obj->nombre,
                    $obj->apellido1,
                    $obj->apellido2,
                    $obj->email,
                    $obj->fechaNac,
                    $this->calcularEdad($obj->fechaNac),
                    $obj->genero = implode(",", $obj->intereses),
                    $obj->edoCivil,
                    $obj->password,
                    $obj->id
                )
            );
            return true;
        } catch (PDOException $e) {
            //Si quieres acceder expecíficamente al numero de error
            //se puede consultar la propiedad errorInfo
            return false;
        } finally {
            Conexion::desconectar();
        }
    }


    /**
     * Agrega un nuevo usuario de acuerdo al objeto recibido como parámetro
     */
    public function agregar(Usuario $obj)
    {
        $clave = 0;
        try {
            $sql = "INSERT INTO Usuarios
                (nombre,
                apellido1,
                apellido2,
                email,
                fechaNac,
                edad,
                genero,
                intereses,
                estadoCivil,
                password)
                VALUES
                (:nombre,
                :apellido1,
                :apellido2,
                :email,
                :fechaNac,
                :edad,
                :genero,
                :intereses,
                :estadoCivil,
                sha2(:password,224));";

            $this->conectar();
            $this->conexion->prepare($sql)
                ->execute(array(
                    ':nombre' => $obj->nombre,
                    ':apellido1' => $obj->apellido1,
                    ':apellido2' => $obj->apellido2,
                    ':email' => $obj->email,
                    ':fechaNac' => $obj->fechaNac->format('Y-m-d'),
                    ':edad' => $this->calcularEdad($obj->fechaNac),
                    ':genero' => $obj->genero,
                    ':intereses' => implode(",", $obj->intereses),
                    ':estadoCivil' => $obj->edoCivil,
                    ':password' => $obj->password
                ));

            $clave = $this->conexion->lastInsertId();
            return $clave;
        } catch (Exception $e) {
            return $clave;
        } finally {

            /*En caso de que se necesite manejar transacciones, 
			no deberá desconectarse mientras la transacción deba 
			persistir*/

            Conexion::desconectar();
        }
    }
}
