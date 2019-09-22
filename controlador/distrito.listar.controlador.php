<?php

require_once '../negocio/Distrito.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if ( !isset( $_POST["codigo_provincia"] )){
        Funciones::imprimeJSON(500, "Faltan parametros", "");
        exit;
    }
    $codigoDepar = $_POST["codigo_departamento"];
    $codigoProv = $_POST["codigo_provincia"];
    
    $objDistrito = new Distrito();
    $resultado = $objDistrito->listar($codigoDepar, $codigoProv);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

