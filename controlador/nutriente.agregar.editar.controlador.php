<?php

require_once '../negocio/Nutriente.clase.php';
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
    $objNutriente = new Nutriente();
    $objNutriente->setNombre( $datosFormularioArray["txtnombre"] );
    $objNutriente->setCodigoTipoNutriente( $datosFormularioArray["cbotiponutrientemodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objNutriente->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objNutriente->setCodigoNutriente( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objNutriente->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
