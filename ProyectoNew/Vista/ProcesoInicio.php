<?php
    require_once('../datos/daoUsuario.php');
    
    //Verificar que llegan datos
    if(ISSET($_POST["correo"]) && ISSET($_POST["password"])){
        //Conectarme y buscar usuario
        $dao=new DaoAdmin();
        $username=$dao->login($_POST["correo"],$_POST["password"]);
        
        if($username){
            session_start();
            $_SESSION["nombre"]=$username->UsuarioAd;
            
            header("Location: ListaAdmin.php");        
            return;
        }
    }
    header("Location: index.html");
?>