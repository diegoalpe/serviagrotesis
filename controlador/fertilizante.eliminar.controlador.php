<?php

    require_once '../negocio/Fertilizante.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_codigo_fertilizante"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objFertilizante = new Fertilizante();
        $codigoFertilizante = $_POST["p_codigo_fertilizante"];
        $resultado = $objFertilizante->eliminar($codigoFertilizante);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    