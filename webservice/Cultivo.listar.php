<?php

require_once '../negocio/Cultivo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {    
        $obj = new Cultivo();
        $resultado = $obj->Listar2();
        
        
         $listaCultivo = array();
        for ($i = 0; $i < count($resultado); $i++){ 
        
            $foto = $obj->obtenerFoto ($resultado[$i]["codigo_cultivo"]);
        
            $datosCultivo = array(
                "codigo" => $resultado[$i]["codigo_cultivo"],
                "nombre" => $resultado[$i]["nombre"],
                "semilla" => $resultado[$i]["semilla"],
                "foto" => $foto
            );
            
            $listaCultivo[$i] = $datosCultivo;
        }
        
        Funciones::imprimeJSON(200, "", $listaCultivo);
   
    
    
} catch (Exception $exc) {
    
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
