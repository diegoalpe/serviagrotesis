<?php

require_once '../datos/Conexion.clase.php';

class Fertilizante extends Conexion {
    private $codigoFertilizante;
    private $nombre;
    private $peso;
    private $componente;
    private $codigoTipoFertilizante;
    
    function getCodigoFertilizante() {
        return $this->codigoFertilizante;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPeso() {
        return $this->peso;
    }

    function getComponente() {
        return $this->componente;
    }

    function getCodigoTipoFertilizante() {
        return $this->codigoTipoFertilizante;
    }

    function setCodigoFertilizante($codigoFertilizante) {
        $this->codigoFertilizante = $codigoFertilizante;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setComponente($componente) {
        $this->componente = $componente;
    }

    function setCodigoTipoFertilizante($codigoTipoFertilizante) {
        $this->codigoTipoFertilizante = $codigoTipoFertilizante;
    }

    
    
    public function listar($p_codigoTipoFer){
        try {
            $sql = "select * from f_listar_fertilizante(:p_codigo_tipo_fertilizante)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_codigo_tipo_fertilizante", $p_codigoTipoFer);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }


    public function cargarListaDatos($p_codigoTipoFer){
	try {
            $sql = " select * from fertilizante where codigo_tipo_fertilizante = :p_codigo_tipo_fertilizante order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_fertilizante", $p_codigoTipoFer);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($codigoFer) {
        try {
            $sql = "
                    select
                            *
                    from
                            fertilizante
                    where
                            codigo_fertilizante = :p_codigo_fertilizante
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_fertilizante", $codigoFer);
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
                    UPDATE public.fertilizante
                        SET nombre = :p_nombre, peso = :p_peso, componente = :p_componente, codigo_tipo_fertilizante = :p_codigo_tipo_fertilizante
                      WHERE codigo_fertilizante = :p_codigo_fertilizante;

               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_fertilizante", $this->getCodigoFertilizante());
            $sentencia->bindParam(":p_peso", $this->getPeso());
            $sentencia->bindParam(":p_componente", $this->getComponente());
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
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('fertilizante') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoFer = $resultado["nc"];
                $this->setCodigoFertilizante($nuevoCodigoFer);
                
                $sql = "
                        INSERT INTO public.fertilizante(
                                codigo_fertilizante, 
                                nombre, 
                                peso,
                                componente,
                                codigo_tipo_fertilizante)
                        VALUES (
                                :p_codigo_fertilizante, 
                                :p_nombre, 
                                :p_peso,
                                :p_componente,
                                :p_codigo_tipo_fertilizante
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_fertilizante", $this->getCodigoFertilizante());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                $sentencia->bindParam(":p_peso", $this->getPeso());
                $sentencia->bindParam(":p_componente", $this->getComponente());
                $sentencia->bindParam(":p_codigo_tipo_fertilizante", $this->getCodigoTipoFertilizante());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'fertilizante'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla fertilizante");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function eliminar( $p_codigo_fertilizante ){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from fertilizante where codigo_fertilizante = :p_codigo_fertilizante";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_fertilizante", $p_codigo_fertilizante);
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
