<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Nutriente.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $p_codigoTipoNu = $_POST["p_codigoTipou"];
        
	$obj = new Nutriente();
        $resultado = $obj->cargarListaDatos($p_codigoTipoNu);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
