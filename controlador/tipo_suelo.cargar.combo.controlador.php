<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Tipo_suelo.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$objTipoSu = new Tipo_suelo();
        $resultado = $objTipoSu->cargarListaDatos();
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
