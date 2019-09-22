<?php

require_once '../datos/Conexion.clase.php';

class Provincia extends Conexion {
    private $codigoProvincia;
    private $nombre;
    private $codigoDepartamento;
    
    function getCodigoProvincia() {
        return $this->codigoProvincia;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodigoDepartamento() {
        return $this->codigoDepartamento;
    }

    function setCodigoProvincia($codigoProvincia) {
        $this->codigoProvincia = $codigoProvincia;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodigoDepartamento($codigoDepartamento) {
        $this->codigoDepartamento = $codigoDepartamento;
    }

    
    
    public function listar($p_codigoDepartamento){
        try {
            $sql = "select * from f_listar_provincia(:p_codigo_departamento)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_codigo_departamento", $p_codigoDepartamento);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }


    public function cargarListaDatos($p_codigoDepartamento){
	try {
            $sql = " select * from provincia where codigo_departamento = :p_codigo_departamento order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_departamento", $p_codigoDepartamento);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($codigoPro) {
        try {
            $sql = "
                    select
                            *
                    from
                            provincia
                    where
                            codigo_provincia = :p_codigo_provincia
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_provincia", $codigoPro);
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
                    UPDATE public.provincia
                        SET nombre = :p_nombre, codigo_departamento = :p_codigo_departamento
                      WHERE codigo_provincia = :p_codigo_provincia;

               ";
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_departamento", $this->getCodigoDepartamento());
            $sentencia->bindParam(":p_codigo_provincia", $this->getCodigoProvincia());

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
            $sql = "select * from f_generar_correlativo('provincia') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoNu = $resultado["nc"];
                $this->setCodigoProvincia($nuevoCodigoNu);
                
                $sql = "
                        INSERT INTO public.provincia(
                                codigo_provincia, 
                                nombre, 
                                codigo_departamento)
                        VALUES (
                                :p_codigo_provincia, 
                                :p_nombre, 
                                :p_codigo_departamento
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_provincia", $this->getCodigoProvincia());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                $sentencia->bindParam(":p_codigo_departamento", $this->getCodigoDepartamento());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'provincia'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla provincia");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function eliminar( $p_codigo_provincia ){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from provincia where codigo_provincia = :p_codigo_provincia";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_provincia", $p_codigo_provincia);
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
