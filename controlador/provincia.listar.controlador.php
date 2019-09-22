<?php

require_once '../negocio/Provincia.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    $codigoDepar = $_POST["codigoDepartamento"];
    
    $objProvincia = new Provincia();
    $resultado = $objProvincia->listar($codigoDepar);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

