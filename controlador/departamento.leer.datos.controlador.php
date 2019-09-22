
<?php

require_once '../negocio/Departamento.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigo_departamento"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objDepartamento = new Departamento();
    $codigoDepar = $_POST["p_codigo_departamento"];
    $resultado = $objDepartamento->leerDatos($codigoDepar);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


