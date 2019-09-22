<?php

require_once '../negocio/Tipo_fertilizante.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_tipo_fertilizante"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objTipoFer = new Tipo_fertilizante();
    $codigoTipoFer = $_POST["p_codigo_tipo_fertilizante"];
    $resultado = $objTipoFer->leerDatos($codigoTipoFer);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


