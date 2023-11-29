<?php
    require_once('../datos/DAOUsuario.php');
    
    //Verificar que llegan datos
    if(ISSET($_POST["correo"]) && ISSET($_POST["password"])){
        //Conectarme y buscar usuario
        $dao=new DAOUsuario();
        $usuario=$dao->autenticar($_POST["correo"],$_POST["password"]);
        
        if($usuario){
            session_start();
            $_SESSION["usuario"]=$usuario->id;
            $_SESSION["nombre"]=$usuario->nombre." ".$usuario->apellido1;
            
            header("Location: listaUsuarios.php");        
            return;
        }
    }
    header("Location: index.php");
?>