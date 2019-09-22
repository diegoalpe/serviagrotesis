<?php

require_once '../negocio/Agricultor.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if ( !isset( $_POST["codigoDistrito"] )){
        Funciones::imprimeJSON(500, "Faltan parametros", "");
        exit;
    }
    $codigoDepartamento = $_POST["codigoDepartamento"];
    $codigoProvincia = $_POST["codigoProvincia"];
    $codigoDistrito = $_POST["codigoDistrito"];
    
    $objAgricultor = new Agricultor();
    $resultado = $objAgricultor->listar($codigoDepartamento, $codigoProvincia, $codigoDistrito);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

