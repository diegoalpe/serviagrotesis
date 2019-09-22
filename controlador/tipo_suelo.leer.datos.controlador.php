<?php

require_once '../negocio/Tipo_suelo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_tipo_suelo"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objTipoSu = new Tipo_suelo();
    $codigoTipoSu = $_POST["p_codigo_tipo_suelo"];
    $resultado = $objTipoSu->leerDatos($codigoTipoSu);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


