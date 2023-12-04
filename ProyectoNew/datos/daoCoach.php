<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php';
require_once '../modelos/coach.php';
require_once '../modelos/equipos.php';
require_once '../modelos/instituciones.php';

class DAOCoach
{
    /**
     * Permite obtener la conexión a la BD
     */
    private $conexion;
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
            /* Se arma la sentencia SQL para seleccionar todos los registros de la base de datos */
            $sentenciaSQL = $this->conexion->prepare("SELECT * FROM Coach");

            // Se ejecuta la sentencia SQL, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /* Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos */
            /* Se recorre el cursor para obtener los datos */
            foreach ($resultado as $row) {
                $obj = new Coach();

                $obj->IdC = $row->id;
                $obj->NombreC = $row->NombreC;
                $obj->CorreoC = $row->CorreoC;
                $obj->Institucion = $row->NombreI;
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


    /**
     * Metodo que obtiene un registro de la base de datos, retorna un objeto  
     */
    public function obtenerUno($IdE)
    {
        try {
            $this->conectar();

            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT IdE,NombreEquipo,Estudiante1,Estudiante2,Estudiante3,Coach,NombreI FROM Equipos WHERE IdE=?");
            $sentenciaSQL->execute(array($IdE));
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            if ($resultado) {
                $obj = new Equipos();

                $obj->IdE = $resultado->IdE;
                $obj->NombreEquipo = $resultado->NombreEquipo;
                $obj->Estudiante1 = $resultado->Estudiante1;
                $obj->Estudiante2 = $resultado->Estudiante2;
                $obj->Estudiante3 = $resultado->Estudiante3;
                $obj->Coach = $resultado->Coach;
                $obj->NombreI = $resultado->NombreI;
            }
            return $obj;
        } catch (Exception $e) {
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
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT NombreI FROM Instituciones");

            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
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
    public function autenticar($CorreoC, $PassCo)
    {
        try {
            $this->conectar();

            //Almacenará el registro obtenido de la BD
            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT IdE,NombreEquipo FROM Equipos WHERE Coach=? AND password=sha2(?,224)");
            //Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute(array($CorreoC, $PassCo));

            /*Obtiene los datos*/
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            if ($fila) {
                $obj = new Equipos();

                $obj->IdE = $fila->IdE;
                $obj->NombreEquipo = $fila->NombreEquipo;
            } else {
                $obj = null;
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
    public function eliminar($IdE)
    {
        try {
            $this->conectar();

            $sentenciaSQL = $this->conexion->prepare("DELETE FROM Equipos WHERE IdE = ?");
            $resultado = $sentenciaSQL->execute(array($IdE));
            return $resultado;
        } catch (PDOException $e) {
            //Si quieres acceder expecíficamente al numero de error
            //se puede consultar la propiedad errorInfo
            return false;
        } finally {
            Conexion::desconectar();
        }
    }



    /**
     * Función para editar a los equipos de acuerdo al objeto recibido como parámetro
     */
    public function editar(Equipos $obj)
    {
        try {
            $sql = "UPDATE Equipos
            SET
            NombreEquipo = ?,
            Estudiante1 = ?,
            Estudiante2 = ?,
            Estudiante3 = ?,
            Coach = ?,
            NombreI = ?
            WHERE IdE = ?;";

            $this->conectar();

            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute(
                array(
                    $obj->NombreEquipo,
                    $obj->Estudiante1,
                    $obj->Estudiante2,
                    $obj->Estudiante3,
                    $obj->Coach,
                    $obj->NombreI,
                    $obj->IdE
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
    public function agregar(Equipos $obj)
    {
        $clave = 0;
        try {
            $sql = "INSERT INTO Equipos
                (NombreEquipo,
                Estudiante1,
                Estudiante2,
                Estudiante3,
                Coach,
                NombreI)
                VALUES
                (:NombreEquipo,
                :Estudiante1,
                :Estudiante2,
                :Estudiante3,
                :Coach,
                :NombreI);";

            $this->conectar();
            $this->conexion->prepare($sql)
                ->execute(array(
                    ':nombreEquipo' => $obj->NombreEquipo,
                    ':estudiante1' => $obj->Estudiante1,
                    ':estudiante2' => $obj->Estudiante2,
                    ':estudiante3' => $obj->Estudiante3,
                    ':coach' => $obj->Coach,
                    ':nombreI' => $obj->NombreI
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
