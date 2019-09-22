<?php

require_once '../negocio/Tipo_fertilizante.clase.php';
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
    $objTipoFer = new Tipo_fertilizante();
    $objTipoFer->setNombre( $datosFormularioArray["txtnombre"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objTipoFer->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objTipoFer->setCodigoTipoFertilizante( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objTipoFer->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
