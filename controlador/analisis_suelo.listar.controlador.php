<?php

require_once '../negocio/Analisis_suelo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    $codigoAgricultor = $_POST["codigoAgricultor"];
    
    $objAnalisisSuelo = new Analisis_suelo();
    $resultado = $objAnalisisSuelo->listar($codigoAgricultor);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

