<?php

require_once '../negocio/Distrito.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);

//echo '<pre>';
//print_r($datosFormularioArray);
//echo '</pre>';

try {
    $objDistrito = new Distrito();
    $objDistrito->setCodigo_departamento( $datosFormularioArray["cbodepartamentomodal"] );
    $objDistrito->setCodigo_provincia( $datosFormularioArray["cboprovinciamodal"] );
    $objDistrito->setNombre( $datosFormularioArray["txtnombre"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objDistrito->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objDistrito->setCodigo_distrito( $datosFormularioArray["txtcodigo"] );
        $resultado = $objDistrito->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


