<?php

require_once '../negocio/Cultivo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    $codigoAgricultor = $_POST["codigoAgricultor"];
    
    $objCultivo = new Cultivo();
    $resultado = $objCultivo->listar($codigoAgricultor);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

