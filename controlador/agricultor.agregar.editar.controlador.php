<?php

require_once '../negocio/Agricultor.clase.php';
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
    $objAgricultor = new Agricultor();
    $objAgricultor->setApellido_paterno( $datosFormularioArray["txtpaterno"] );
    $objAgricultor->setApellido_materno( $datosFormularioArray["txtmaterno"] );
    $objAgricultor->setNombres( $datosFormularioArray["txtnombre"] );
    $objAgricultor->setDireccion( $datosFormularioArray["txtdireccion"] );
    $objAgricultor->setUsuario( $datosFormularioArray["txtemail"] );
    $objAgricultor->setNum_celular( $datosFormularioArray["txtcelular"] );
    $objAgricultor->setCodigo_departamento( $datosFormularioArray["cbodepartamentomodal"] );
    $objAgricultor->setCodigo_provincia( $datosFormularioArray["cboprovinciamodal"] );
    $objAgricultor->setCodigo_distrito( $datosFormularioArray["cbodistritomodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objAgricultor->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objAgricultor->setCodigo_agricultor( $datosFormularioArray["txtcodigo"] );
        
        $resultado = $objAgricultor->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


