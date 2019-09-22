<?php

    require_once '../negocio/Departamento.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_codigo_departamento"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objDepartamento = new Departamento();
        $codigoDepar = $_POST["p_codigo_departamento"];
        $resultado = $objDepartamento->eliminar($codigoDepar);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    