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
    private static $puerto = '3006';
    
    //Referencia de la conexión a la BD para que 
    //si ocupamos transacciones podamos usar siempre la misma
    //conexion
    private static $conexion  = null;

    /**
     * No se permite realizar instancias de la clase
     */
    public function __construct() {
        //Debido a que se usarán miembros estáticos evitamos hacer 
        //instancias
        exit('Instancia no permitida');
    }
    
    /**
     * Funcion que permite abrir una nueva conexion a la base de datos 
     */
    public static function conectar()
    {
        //self permite hacer una referencia al elemento estático
        //this permite hacer una referencia a un elemento de instancia
        //Se verifica si ya hay una conexión abierta
        if (self::$conexion==null)
        {     
            try
            {
                self::$conexion =  new PDO( "mysql:host=".self::$servidor.";port=".self::$puerto.";dbname=".self::$db, self::$usuario, self::$password); 
                //self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                exit($e->getMessage()); 
            }
        }
        return self::$conexion;
    }
    
    /**
     * Funcion que permite cerrar la conexion a la base de datos 
     */
    public static function desconectar()
    {
        self::$conexion = null;
    }
}
?>