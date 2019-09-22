<?php

require_once '../negocio/Nutriente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_nutriente"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objNutriente = new Nutriente();
    $codigoNutriente = $_POST["p_codigo_nutriente"];
    $resultado = $objNutriente->leerDatos($codigoNutriente);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


