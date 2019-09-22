<?php

    require_once '../negocio/Tipo_suelo.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_codigo_tipo_suelo"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objTipoSu = new Tipo_suelo();
        $codigoTipoSu = $_POST["p_codigo_tipo_suelo"];
        $resultado = $objTipoSu->eliminar($codigoTipoSu);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    