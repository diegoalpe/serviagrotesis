<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Cultivo.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $p_codigoCultivo = $_POST["p_codigoCultivo"];
        
	$obj = new Cultivo();
        $resultado = $obj->cargarListaDatos($p_codigoCultivo);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
