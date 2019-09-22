<?php

require_once '../negocio/Nutriente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    $codigoTipoNu = $_POST["codigoTipoNu"];
    
    $objNutriente = new Nutriente();
    $resultado = $objNutriente->listar($codigoTipoNu);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

