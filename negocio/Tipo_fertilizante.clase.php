<?php

require_once '../datos/Conexion.clase.php';

class Tipo_fertilizante extends Conexion {
    
    private $codigoTipoFertilizante;
    private $nombre;
    
    function getCodigoTipoFertilizante() {
        return $this->codigoTipoFertilizante;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setCodigoTipoFertilizante($codigoTipoFertilizante) {
        $this->codigoTipoFertilizante = $codigoTipoFertilizante;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function listarTipoFertilizante(){
        try {
            $sql = "select * from tipo_fertilizante order by 1 asc";
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
            $sql = "select * from tipo_fertilizante order by 1";
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
            $sql = "select * from f_generar_correlativo('tipo_fertilizante') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoTipoFer = $resultado["nc"];
                $this->setCodigoTipoFertilizante($nuevoCodigoTipoFer);
                
                $sql = "
                        INSERT INTO public.tipo_fertilizante(
                                codigo_tipo_fertilizante, nombre)
                        VALUES (:p_codigo_tipo_fertilizante, :p_nombre);

                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_tipo_fertilizante", $this->getCodigoTipoFertilizante());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'tipo_fertilizante'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla tipo_fertilizante");
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
                    UPDATE public.tipo_fertilizante
                        SET  nombre = :p_nombre
                      WHERE codigo_tipo_fertilizante = :p_codigo_tipo_fertilizante;
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_tipo_fertilizante", $this->getCodigoTipoFertilizante());

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
    
    public function leerDatos($codigoTipoFertilizante) {
        try {
            $sql = "
                    select
                            *
                    from
                            tipo_fertilizante
                    where
                            codigo_tipo_fertilizante = :p_codigo_tipo_fertilizante
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_fertilizante", $codigoTipoFertilizante);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar($codigoTipoFertilizante){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from tipo_fertilizante where codigo_tipo_fertilizante = :p_codigo_tipo_fertilizante";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_fertilizante", $codigoTipoFertilizante);
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