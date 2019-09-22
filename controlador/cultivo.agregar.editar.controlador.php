<?php

require_once '../negocio/Cultivo.clase.php';
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
    $objCultivo = new Cultivo();
    $objCultivo->setNombre( $datosFormularioArray["txtnombre"] );
    $objCultivo->setSemilla( $datosFormularioArray["txtsemilla"] );
    $objCultivo->setCodigo_agricultor( $datosFormularioArray["cboagricultormodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objCultivo->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objCultivo->setCodigo_cultivo( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objCultivo->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
