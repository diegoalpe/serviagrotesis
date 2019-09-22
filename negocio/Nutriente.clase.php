<?php

require_once '../datos/Conexion.clase.php';

class Nutriente extends Conexion {
    private $codigoNutriente;
    private $nombre;
    private $codigoTipoNutriente;
    
    function getCodigoNutriente() {
        return $this->codigoNutriente;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodigoTipoNutriente() {
        return $this->codigoTipoNutriente;
    }

    function setCodigoNutriente($codigoNutriente) {
        $this->codigoNutriente = $codigoNutriente;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodigoTipoNutriente($codigoTipoNutriente) {
        $this->codigoTipoNutriente = $codigoTipoNutriente;
    }

    
    public function listar($p_codigoTipoNu){
        try {
            $sql = "select * from f_listar_nutriente(:p_codigo_tipo_nutriente)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_codigo_tipo_nutriente", $p_codigoTipoNu);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }


    public function cargarListaDatos($p_codigoTipoNu){
	try {
            $sql = " select * from nutriente where codigo_tipo_nutriente = :p_codigo_tipo_nutriente order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_nutriente", $p_codigoTipoNu);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($codigoNu) {
        try {
            $sql = "
                    select
                            *
                    from
                            nutriente
                    where
                            codigo_nutriente = :p_codigo_nutriente
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_nutriente", $codigoNu);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = "     
                    UPDATE public.nutriente
                        SET nombre = :p_nombre, codigo_tipo_nutriente = :p_codigo_tipo_nutriente
                      WHERE codigo_nutriente = :p_codigo_nutriente;

               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_tipo_nutriente", $this->getCodigoTipoNutriente());
            $sentencia->bindParam(":p_codigo_nutriente", $this->getCodigoNutriente());

            //Ejecutar la sentencia preparada
            $sentencia->execute();
            
            
            $this->dblink->commit();
                
            return true;
            
        } catch (Exception $exc) {
           $this->dblink->rollBack();
           throw $exc;
        }
        
        return false;
            
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('nutriente') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoNu = $resultado["nc"];
                $this->setCodigoNutriente($nuevoCodigoNu);
                
                $sql = "
                        INSERT INTO public.nutriente(
                                codigo_nutriente, 
                                nombre, 
                                codigo_tipo_nutriente)
                        VALUES (
                                :p_codigo_nutriente, 
                                :p_nombre, 
                                :p_codigo_tipo_nutriente
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_nutriente", $this->getCodigoNutriente());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                $sentencia->bindParam(":p_codigo_tipo_nutriente", $this->getCodigoTipoNutriente());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'nutriente'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla nutriente");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function eliminar( $p_codigo_nutriente ){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from nutriente where codigo_nutriente = :p_codigo_nutriente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_nutriente", $p_codigo_nutriente);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
}
