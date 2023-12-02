<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php';
require_once '../modelos/coach';
require_once '../modelos/equipos'

class DAOCoach
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
            $sentenciaSQL = $this->conexion->prepare("SELECT IdE,NombreEquipo,Estudiante1,Estudiante2,Estudiante3,Coach,NombreI FROM Equipos");

            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute();

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
            foreach ($resultado as $fila) {
                $obj = new Coach();
                $obj->IdE = $fila->IdE;
                $obj->NombreEquipo = $fila->NombreEquipo;
                $obj->Estudiante1 = $fila->Estudiante1;
                $obj->Estudiante2 = $fila->Estudiante2;
                $obj->Estudiante3 = $fila->Estudiante3;  
                $obj->Coach = $fila->Coach;
                $obj->NombreI = $fila->nombreI;


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
    public function obtenerUno($IdE)
    {
        try {
            $this->conectar();

            //Almacenará el registro obtenido de la BD
            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT IdE,NombreEquipo,Estudiante1,Estudiante2,Estudiante3,Coach,NombreI FROM Equipos WHERE IdE=?");
            //Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$IdE]);

            /*Obtiene los datos*/
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            $obj = new Coach();

            $obj->IdE = $fila->IdE;
            $obj->NombreEquipo = $fila->NombreEquipo;
            $obj->Estudiante1 = $fila->Estudiante1;
            $obj->Estudiante2 = $fila->Estudiante2;
            $obj->Estudiante3 = $fila->Estudiante3;  
            $obj->Coach = $fila->Coach;
            $obj->NombreI = $fila->nombreI;

            return $obj;
        } catch (Exception $e) {
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
                $obj = new Equipo();

                $obj->IdE = $fila->IdE;
                $obj->NombreEquipo = $fila->NombreEquipo;
                

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
    public function editar(Equipo $obj)
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
    public function agregar(Equipo $obj)
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
