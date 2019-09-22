<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Fertilizante.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $p_codigoTipoFer = $_POST["p_codigoTipoFe"];
        
	$obj = new Fertilizante();
        $resultado = $obj->cargarListaDatos($p_codigoTipoFer);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
