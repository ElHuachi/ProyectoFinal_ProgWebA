<?php
//importa la clase conexión y el modelo para usarlos
require_once('conexion.php');
require_once __DIR__ . '/../modelos/coach.php';
require_once __DIR__ . '/../modelos/equipos.php';
require_once __DIR__ . '/../modelos/instituciones.php';

class DAOCoach
{
    /**
     * Permite obtener la conexión a la BD
     */
    private $conexion;
    private function conectar()
    {
        //creamos una instancia de la clase conexión
        if (session_status()) {
        }

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
                $obj->Institucion = $resultado->Institucion;
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
    public function autenticarCoach($correo, $contrasena)
    {
        try {
            $this->conectar();
    
            $obj = null;
    
            $sentenciaSQL = $this->conexion->prepare("SELECT IdC, NombreC FROM Coach WHERE CorreoC=? AND PassCo=SHA2(?, 224)");
            $sentenciaSQL->execute(array($correo, $contrasena));
    
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
    
            if ($resultado) {
                $obj = new Coach();
                $obj->IdC = $resultado->IdC;
                $obj->NombreC = $resultado->NombreC;
            }
    
            return $obj;
        } catch (Exception $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    /**
     * Elimina el usuario con el id indicado como parámetro
     */
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
                    $obj->Institucion,
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
    public function insertarCoach($coach)
{
    try {
        $this->conectar();

        // Preparar la consulta SQL
        $query = "INSERT INTO Coach (NombreC, CorreoC, Institucion, idTipo, PassCo) VALUES (?, ?, ?, ?, sha2(?,224))";
        $statement = $this->conexion->prepare($query);

        // Vincular los parámetros
        $statement->bindParam(1, $coach->NombreC);
        $statement->bindParam(2, $coach->CorreoC);
        $statement->bindParam(3, $coach->Institucion);
        $statement->bindParam(4, $coach->idTipo);
        $statement->bindParam(5, $coach->PassCo);

        // Ejecutar la consulta
        $resultado = $statement->execute();

        // Cerrar la declaración
        $statement->closeCursor(); // Usar closeCursor en lugar de close

        return $resultado;
    } catch (PDOException $e) {
        // Manejar la excepción según tus necesidades
        // Aquí puedes registrar el error, lanzar una excepción personalizada, etc.
        return false;
    } finally {
        Conexion::desconectar();
    }
}
}
