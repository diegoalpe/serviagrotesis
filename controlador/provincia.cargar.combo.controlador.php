<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Provincia.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $p_codigoDepartamento = $_POST["p_codigoDepartamento"];
        
	$obj = new Provincia();
        $resultado = $obj->cargarListaDatos($p_codigoDepartamento);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
