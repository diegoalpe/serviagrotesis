<?php

require_once '../negocio/Tipo_nutriente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_tipo_nutriente"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objTipoNu = new Tipo_nutriente();
    $codigoTipoNu = $_POST["p_codigo_tipo_nutriente"];
    $resultado = $objTipoNu->leerDatos($codigoTipoNu);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


