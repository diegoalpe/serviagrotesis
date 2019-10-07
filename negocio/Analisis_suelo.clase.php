<?php

require_once '../datos/Conexion.clase.php';

class Analisis_suelo extends Conexion {
        
    private $codigo_agricultor;
    private $apellido_paterno;
    private $apellido_materno;
    private $nombres;
    private $direccion;
    private $num_celular;
    private $usuario;
    private $codigo_departamento;
    private $codigo_provincia;
    private $codigo_distrito;
    
    function getCodigo_agricultor() {
        return $this->codigo_agricultor;
    }

    function getApellido_paterno() {
        return $this->apellido_paterno;
    }

    function getApellido_materno() {
        return $this->apellido_materno;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getNum_celular() {
        return $this->num_celular;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getCodigo_departamento() {
        return $this->codigo_departamento;
    }

    function getCodigo_provincia() {
        return $this->codigo_provincia;
    }

    function getCodigo_distrito() {
        return $this->codigo_distrito;
    }

    function setCodigo_agricultor($codigo_agricultor) {
        $this->codigo_agricultor = $codigo_agricultor;
    }

    function setApellido_paterno($apellido_paterno) {
        $this->apellido_paterno = $apellido_paterno;
    }

    function setApellido_materno($apellido_materno) {
        $this->apellido_materno = $apellido_materno;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setNum_celular($num_celular) {
        $this->num_celular = $num_celular;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setCodigo_departamento($codigo_departamento) {
        $this->codigo_departamento = $codigo_departamento;
    }

    function setCodigo_provincia($codigo_provincia) {
        $this->codigo_provincia = $codigo_provincia;
    }

    function setCodigo_distrito($codigo_distrito) {
        $this->codigo_distrito = $codigo_distrito;
    }

    public function listar( $p_codigo_departamento, $p_codigo_provincia, $p_codigo_distrito) {
        try {
            $sql = "select * from f_listar_agricultor(:p_codigo_departamento,:p_codigo_provincia,:p_codigo_distrito)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_departamento", $p_codigo_departamento);
            $sentencia->bindParam(":p_codigo_provincia", $p_codigo_provincia);
            $sentencia->bindParam(":p_codigo_distrito", $p_codigo_distrito);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function cargarListaDatos() {
        try {
            $sql = "select codigo_agricultor, (apellido_paterno || ' ' || apellido_materno || ' ' || nombres) as nombre from agricultor order by 1";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('agricultor') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoAgricultor = $resultado["nc"];
                $this->setCodigo_agricultor($nuevoCodigoAgricultor);
                
                $sql = "
                        INSERT INTO agricultor
                                (
                                        codigo_agricultor, 
                                        apellido_paterno, 
                                        apellido_materno, 
                                        nombres, 
                                        direccion, 
                                        usuario, 
                                        num_celular, 
                                        codigo_departamento, 
                                        codigo_provincia, 
                                        codigo_distrito
                                )
                            VALUES 
                                (
                                        :p_codigo_agricultor, 
                                        :p_apellido_paterno, 
                                        :p_apellido_materno, 
                                        :p_nombres, 
                                        :p_direccion, 
                                        :p_usuario, 
                                        :p_num_celular,
                                        :p_codigo_departamento, 
                                        :p_codigo_provincia, 
                                        :p_codigo_distrito
                                )
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_agricultor", $this->getCodigo_agricultor());
                $sentencia->bindParam(":p_apellido_paterno", $this->getApellido_paterno());
                $sentencia->bindParam(":p_apellido_materno", $this->getApellido_materno());
                $sentencia->bindParam(":p_nombres", $this->getNombres());
                $sentencia->bindParam(":p_direccion", $this->getDireccion());
                $sentencia->bindParam(":p_usuario", $this->getUsuario());
                $sentencia->bindParam(":p_num_celular", $this->getNum_celular());
                $sentencia->bindParam(":p_codigo_departamento", $this->getCodigo_departamento());
                $sentencia->bindParam(":p_codigo_provincia", $this->getCodigo_provincia());
                $sentencia->bindParam(":p_codigo_distrito", $this->getCodigo_distrito());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'agricultor'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla agricultor");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function leerDatos($p_codigoAgricultor) {
        try {
            $sql = "
                    SELECT 
                            codigo_agricultor, 
                            apellido_paterno, 
                            apellido_materno, 
                            nombres, 
                            direccion, 
                            usuario, 
                            num_celular, 
                            codigo_departamento, 
                            codigo_provincia, 
                            codigo_distrito
                        FROM agricultor
                        where codigo_agricultor = :p_codigo_agricultor
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_agricultor", $p_codigoAgricultor);
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
                    UPDATE cliente SET 
                                    codigo_cliente = :p_codigo_cliente,
                                    apellido_paterno = :p_apellido_paterno, 
                                    apellido_materno = :p_apellido_materno, 
                                    nombres = :p_nombres, 
                                    nro_documento_identidad = :p_nro_documento_identidad, 
                                    direccion = :p_direccion, 
                                    telefono_fijo = :p_telefono_fijo, 
                                    telefono_movil1 = :p_telefono_movil1, 
                                    telefono_movil2 = :p_telefono_movil2, 
                                    email = :p_email, 
                                    direccion_web = :p_direccion_web, 
                                    codigo_departamento = :p_codigo_departamento, 
                                    codigo_provincia = :p_codigo_provincia, 
                                    codigo_distrito = :p_codigo_distrito,
                                    clave = :p_clave
                     WHERE codigo_cliente = :p_codigo_cliente
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());
            $sentencia->bindParam(":p_apellido_paterno", $this->getApellido_paterno());
            $sentencia->bindParam(":p_apellido_materno", $this->getApellido_materno());
            $sentencia->bindParam(":p_nombres", $this->getNombres());
            $sentencia->bindParam(":p_nro_documento_identidad", $this->getNro_documento_identidad());
            $sentencia->bindParam(":p_direccion", $this->getDireccion());
            $sentencia->bindParam(":p_telefono_fijo", $this->getTelefono_fijo());
            $sentencia->bindParam(":p_telefono_movil1", $this->getTelefono_movil1());
            $sentencia->bindParam(":p_telefono_movil2", $this->getTelefono_movil2());
            $sentencia->bindParam(":p_email", $this->getEmail());
            $sentencia->bindParam(":p_direccion_web", $this->getDireccion_web());
            $sentencia->bindParam(":p_codigo_departamento", $this->getCodigo_departamento());
            $sentencia->bindParam(":p_codigo_provincia", $this->getCodigo_provincia());
            $sentencia->bindParam(":p_codigo_distrito", $this->getCodigo_distrito());
            $sentencia->bindParam(":p_clave", $this->getClave());

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
}
