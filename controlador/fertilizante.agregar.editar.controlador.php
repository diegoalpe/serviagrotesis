<?php

require_once '../negocio/Fertilizante.clase.php';
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
    $objFertilizante = new Fertilizante();
    $objFertilizante->setNombre( $datosFormularioArray["txtnombre"] );
    $objFertilizante->setPeso( $datosFormularioArray["txtpeso"] );
    $objFertilizante->setComponente( $datosFormularioArray["txtcomponente"] );
    $objFertilizante->setCodigoTipoFertilizante( $datosFormularioArray["cbotipofertilizantemodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objFertilizante->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objFertilizante->setCodigoFertilizante( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objFertilizante->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
