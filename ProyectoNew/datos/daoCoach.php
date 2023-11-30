<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php';

require_once '../modelos/coach.php';


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

    /**
     * Metodo que obtiene todos los usuarios de la base de datos y los
     * retorna como una lista de objetos  
     */
    public function obtenerTodos()
    {
        try {
            $this->conectar();

            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,correo,institucion FROM Usuarios");

            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
            foreach ($resultado as $fila) {
                $obj = new Coach();
                $obj->id = $fila->id;
                $obj->nombre = $fila->nombre;
                $obj->correo = $fila->correo;
                $obj->institucion= $fila->institucion;
               
                //Agrega el objeto al arreglo, no necesitamos indicar un índice, usa el próximo válido
                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }


    /**
     * Metodo que obtiene un registro de la base de datos, retorna un objeto  
     */
    public function obtenerUno($id)
    {
        try {
            $this->conectar();

            //Almacenará el registro obtenido de la BD
            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,correo,institucion FROM RegistroCoach WHERE id=?");
            //Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$id]);

            /*Obtiene los datos*/
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            $obj = new Coach();

            $obj->id = $fila->id;
            $obj->nombre = $fila->nombre;
            $obj->apellido1 = $fila->apellido1;
            $obj->apellido2 = $fila->apellido2;
            $obj->email = $fila->email;
            $obj->fechaNac = DateTime::createFromFormat('Y-m-d', $fila->fechaNac);
            $obj->genero = $fila->genero;
            $obj->edoCivil = $fila->estadoCivil;
            $obj->intereses = $fila->intereses ? explode(",", $fila->intereses) : array();

            return $obj;
        } catch (Exception $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function autenticar($correo, $password)
    {
        try {
            $this->conectar();

            //Almacenará el registro obtenido de la BD
            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,apellido1,apellido2 FROM usuarios WHERE email=? AND password=sha2(?,224)");
            //Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute(array($correo, $password));

            /*Obtiene los datos*/
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

    /**
     * Elimina el usuario con el id indicado como parámetro
     */
    public function eliminar($id)
    {
        try {
            $this->conectar();

            $sentenciaSQL = $this->conexion->prepare("DELETE FROM usuarios WHERE id = ?");
            $resultado = $sentenciaSQL->execute(array($id));
            return $resultado;
        } catch (PDOException $e) {
            //Si quieres acceder expecíficamente al numero de error
            //se puede consultar la propiedad errorInfo
            return false;
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
