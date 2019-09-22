<?php

require_once '../negocio/Tipo_nutriente.clase.php';
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
    $objTipoNu = new Tipo_nutriente();
    $objTipoNu->setNombre( $datosFormularioArray["txtnombre"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objTipoNu->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objTipoNu->setCodigoTipoNutriente( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objTipoNu->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
