<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Cultivo.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $p_codigoAgricultor = $_POST["p_codigoAgricultor"];
        
	$obj = new Cultivo();
        $resultado = $obj->cargarListaDatosCultivo($p_codigoAgricultor);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
