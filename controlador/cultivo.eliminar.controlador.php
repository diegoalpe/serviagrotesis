<?php

    require_once '../negocio/Cultivo.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_codigo_cultivo"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objCultivo = new Cultivo();
        $codigoCul = $_POST["p_codigo_cultivo"];
        $resultado = $objCultivo->eliminar($codigoCul);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    