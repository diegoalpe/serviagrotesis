<?php

require_once '../negocio/Articulo.clase.php';
require_once 'token.validar.php';
require_once '../util/funciones/Funciones.clase.php';

if (!isset($_POST["token"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$token = $_POST["token"];


try {
    if (validarToken($token)) { //token valido
        $obj = new Articulo();
        $resultado = $obj->listar();
        $listaArticulo = array();    
        
        for ($i = 0; $i < count($resultado); $i++) {

            //obtener foto del articulo
            $foto = $obj->obtenerFoto($resultado[$i]["codigo_articulo"]);
            //obtener foto del articulo

            $datosArticulo = array
                (
                "codigo" => $resultado[$i]["codigo_articulo"],
                "nombre" => $resultado[$i]["nombre"],
                "precio" => $resultado[$i]["precio_venta"],
                "stock" => $resultado[$i]["stock"],
                "foto" => $foto
            );

            $listaArticulo[$i] = $datosArticulo;
        }
        Funciones::imprimeJSON(200, "", $listaArticulo);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}