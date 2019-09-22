<?php

require_once '../datos/Conexion.clase.php';

class Tipo_nutriente extends Conexion {
    
    private $codigoTipoNutriente;
    private $nombre;
    
    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getCodigoTipoNutriente() {
        return $this->codigoTipoNutriente;
    }

    function setCodigoTipoNutriente($codigoTipoNutriente) {
        $this->codigoTipoNutriente = $codigoTipoNutriente;
    }

        
    public function listarTipoNutriente(){
        try {
            $sql = "select * from tipo_nutriente order by 1 asc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function cargarListaDatos(){
        try {
            $sql = "select * from tipo_nutriente order by 1";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('tipo_nutriente') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoTipoNu = $resultado["nc"];
                $this->setCodigoTipoNutriente($nuevoCodigoTipoNu);
                
                $sql = "
                        INSERT INTO public.tipo_nutriente(
                                codigo_tipo_nutriente, nombre)
                        VALUES (:p_codigo_tipo_nutriente, :p_nombre);

                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_tipo_nutriente", $this->getCodigoTipoNutriente());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'tipo_nutriente'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla tipo_nutriente");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = "     
                    UPDATE public.tipo_nutriente
                        SET  nombre = :p_nombre
                      WHERE codigo_tipo_nutriente = :p_codigo_tipo_nutriente;
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_tipo_nutriente", $this->getCodigoTipoNutriente());

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
    
    public function leerDatos($codigoTipoNutriente) {
        try {
            $sql = "
                    select
                            *
                    from
                            tipo_nutriente
                    where
                            codigo_tipo_nutriente = :p_codigo_tipo_nutriente
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_nutriente", $codigoTipoNutriente);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar($codigoTipoNutriente){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from tipo_nutriente where codigo_tipo_nutriente = :p_codigo_tipo_nutriente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_nutriente", $codigoTipoNutriente);
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