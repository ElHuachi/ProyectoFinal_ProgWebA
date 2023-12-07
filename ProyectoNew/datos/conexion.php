<?php
/**
 * Clase que manejará la conexión a la BD
 */
class Conexion
{
    
    private static $servidor = 'localhost' ;
    private static $db = 'Coding' ;
    private static $usuario = 'root';
    private static $password = 'root';
    private static $puerto = '3306';

    private static $conexion  = null;
    
    public static function conectar()
    {
        if (self::$conexion==null)
        {     
            try
            {
                self::$conexion =  new PDO( "mysql:host=".self::$servidor.";port=".self::$puerto.";dbname=".self::$db, self::$usuario, self::$password); 
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                exit($e->getMessage()); 
            }
        }
        return self::$conexion;
    }
    public static function desconectar()
    {
        self::$conexion = null;
    }
}
?>