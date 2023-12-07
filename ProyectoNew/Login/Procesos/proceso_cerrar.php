<?php
session_start();
session_destroy();
header("Location: /ProyectoNew/Principal/index.php");
?>
