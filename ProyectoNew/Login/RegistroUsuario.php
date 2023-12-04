<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        form .row>div {
            margin: .5rem 0;
        }
    </style>
    <link rel="stylesheet" href="../Principal/estilos/estilos.css">
</head>

<body>

    <?php

    // session_start();
    // if (!isset($_SESSION["usuario"])) {
    //     header("Location:index.html");
    // }
    require('../Principal/menu.php');
    require_once('../datos/daoAdmin.php');
    ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/usuario.js"></script>
</body>

</html>