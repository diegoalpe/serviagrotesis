<?php

require_once '../negocio/Fertilizante.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    $codigoTipoFer = $_POST["codigoTipoFer"];
    
    $objFertilizante = new Fertilizante();
    $resultado = $objFertilizante->listar($codigoTipoFer);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
    
} catch (Exception $exc) {
    //Funciones::mensaje($exc->getMessage(), "e");
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

