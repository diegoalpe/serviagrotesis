<?php

require_once '../negocio/Agricultor.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigoAgricultor"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objAgricultor = new Agricultor();
    $codigoAgricultor = $_POST["p_codigoAgricultor"];
    $resultado = $objAgricultor->leerDatos($codigoAgricultor);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

