<?php

require_once '../negocio/Distrito.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_distrito"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objDistrito = new Distrito();
    $codigoDis = $_POST["p_codigo_distrito"];
    $resultado = $objDistrito->leerDatos($codigoDis);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


