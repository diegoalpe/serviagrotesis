<?php

require_once '../datos/Conexion.clase.php';

class Tipo_suelo extends Conexion {
    
    private $codigoSuelo;
    private $nombres;
    private $cargo;
    private $email;
    private $clave;
    private $estado;
    private $apellido_paterno;
    private $apellido_materno;
    
    function getCodigoAdministrador() {
        return $this->codigoAdministrador;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function getEstado() {
        return $this->estado;
    }

    function getApellido_paterno() {
        return $this->apellido_paterno;
    }

    function getApellido_materno() {
        return $this->apellido_materno;
    }

    function setCodigoAdministrador($codigoAdministrador) {
        $this->codigoAdministrador = $codigoAdministrador;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setApellido_paterno($apellido_paterno) {
        $this->apellido_paterno = $apellido_paterno;
    }

    function setApellido_materno($apellido_materno) {
        $this->apellido_materno = $apellido_materno;
    }
    
    public function listarAdministrador(){
        try {
            $sql = "SELECT 
                            codigo_administrador, 
                            apellido_paterno || ' ' || apellido_materno || '' || nombres as nombre, 
                            cargo, 
                            email,
                            estado
                    FROM public.administrador 
                    order by 1 asc;";
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
            $sql = "SELECT 
                            codigo_administrador, 
                            apellido_paterno || ' ' || apellido_materno || '' || nombres as nombre, 
                            cargo, 
                            email,
                            estado
                    FROM public.administrador 
                    order by 1 asc;";
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
            $sql = "select * from f_generar_correlativo('administrador') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoTipoSu = $resultado["nc"];
                $this->setCodigoTipoSuelo($nuevoCodigoTipoSu);
                
                $sql = "
                        INSERT INTO public.administrador(
                                    codigo_administrador, 
                                    apellido_paterno, 
                                    apellido_materno, 
                                    nombres, 
                                    cargo, 
                                    email,
                                    clave)
                            VALUES (                               
                                    :p_codigo_administrador,                          
                                    :p_apellido_paterno,
                                    :p_apellido_materno,
                                    :p_nombres,
                                    :p_cargo,
                                    :p_email,
                                    :p_clave,
                                    );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_administrador", $this->getCodigoAdministrador());
                $sentencia->bindParam(":p_apellido_paterno", $this->getApellido_paterno());
                $sentencia->bindParam(":p_apellido_materno", $this->getApellido_materno());
                $sentencia->bindParam(":p_nombres", $this->getNombres());
                $sentencia->bindParam(":p_cargo", $this->getApellido_paterno());
                $sentencia->bindParam(":p_email", $this->getApellido_paterno());
                $sentencia->bindParam(":p_clave", $this->getApellido_paterno());
                
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'tipo_suelo'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla tipo_suelo");
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
                    UPDATE public.tipo_suelo
                        SET  nombre = :p_nombre
                      WHERE codigo_tipo_suelo = :p_codigo_tipo_suelo;
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_tipo_suelo", $this->getCodigoTipoSuelo());

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
    
    public function leerDatos($codigoTipoSuelo) {
        try {
            $sql = "
                    select
                            *
                    from
                            tipo_suelo
                    where
                            codigo_tipo_suelo = :p_codigo_tipo_suelo
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_suelo", $codigoTipoSuelo);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar($codigoTipoSuelo){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from tipo_suelo where codigo_tipo_suelo = :p_codigo_tipo_suelo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_suelo", $codigoTipoSuelo);
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