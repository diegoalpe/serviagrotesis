<?php

    //require_once 'sesion.validar.controlador.php';

    require_once '../negocio/Agricultor.clase.php';
    require_once '../util/funciones/Funciones.clase.php';
    
    try {
	$objAgricultor = new Agricultor();
        $resultado = $objAgricultor->cargarListaDatos();
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
