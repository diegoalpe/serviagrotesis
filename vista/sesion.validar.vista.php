<?php

session_name("Serviagro");
session_start();

if (! isset( $_SESSION["s_nombre_usuario"] ) ){
    //Esto se cumple cuando el usuario no ha iniciado sesión
    header("location:index.php");
    exit;
}

//Capturando los datos del usuario que ha iniciado sesión
$nombreUsuario = ucwords( strtolower($_SESSION["s_nombre_usuario"]) );
$cargoUsuario = $_SESSION["s_cargo"];

$codigoUsuario = $_SESSION["s_codigo_administrador"];

if (file_exists("../imagenes/".$codigoUsuario . ".jpg" )){
    $fotoUsuario = $codigoUsuario . ".jpg";
} if (file_exists("../imagenes/".$codigoUsuario . ".png" )){
    $fotoUsuario = $codigoUsuario . ".png";
} else{
    $fotoUsuario = "sin-foto.jpg";
}

