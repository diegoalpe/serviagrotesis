<?php

require_once '../negocio/Cultivo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_cultivo"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objCultivo= new Cultivo();
    $codigoCul = $_POST["p_codigo_cultivo"];
    $resultado = $objCultivo->leerDatos($codigoCul);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


