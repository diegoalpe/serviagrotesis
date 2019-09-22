<?php

require_once '../negocio/Departamento.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);

//print_r($datosFormularioArray);
//exit();

try {
    $objDepartamento = new Departamento();
    $objDepartamento->setNombre( $datosFormularioArray["txtnombre"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objDepartamento->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objDepartamento->setCodigoDepartamento( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objDepartamento->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
