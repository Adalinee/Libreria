<?php
//incluir la conexion de base de datos
require_once "../config/Conexion.php";
class Libros
{
    
    //implementamos nuestro constructor
    public function __construct()
    {
    }
    
    
    //peticion para poder hacer la reserva de libro
    public function reservacion($id_libro) //
    {
        $sql = "INSERT INTO reserva (nombre, tipo_documento, num_documento, direccion, telefono, email, idareas, cargo, login, clave, imagen, condicion) 
            VALUES (:nombre, :tipo_documento, :num_documento, :direccion, :telefono, :email, :areas, :cargo, :login, :clave, :imagen, '1')";
        return ejecutarConsulta($sql, $parametros);
    }
    
    
    public function listar($filtrocategoria)
    {    
        $sql = "SELECT l.*, c.descripcion AS nombrecategoria
        FROM libros AS l
        INNER JOIN categoria AS c ON c.id_categoria = l.id_categoria";
        
        $parametros = [];
        
        if ($filtrocategoria == 0) {
             $sql .= " WHERE l.estado = :estado";
             $parametros = array(
                ':estado' => 1
            );
        }  
        else {
            $sql .= " WHERE l.estado = :estado AND l.id_categoria = :filtrocategoria";
            $parametros = array(
                ':estado' => 1,
                ':filtrocategoria' => $filtrocategoria
            );
            
        }
        
        $stmt = ejecutarConsulta($sql, $parametros);
        return $stmt;
        
    }
    
    
    
    public function listarcategorias()
    {    
        $sql = "SELECT *
        FROM categoria
        WHERE estado = :estado";
        
        $parametros = array(':estado' => 1);
        
        return ejecutarConsulta($sql, $parametros);
        
    }
    
    
    

    public function mostrar($id_libro) {
        
        $sql = "SELECT * FROM libros WHERE id_libro = :id_libro";
        $parametros = [':id_libro' => $id_libro];
        return ejecutarConsultaSimpleFila($sql, $parametros);
    }
    
    
    
    //primero registra
    public function insertarreserva($id_libro, $idusuariosesion, $fechaini, $fechafin){
        $sql = "INSERT INTO reserva (id_libro, id, fecha_inicio, fecha_fin, estado) VALUES (:id_libro, :id, :fecha_inicio, :fecha_fin, :estado)";
        $parametros = array(
            ':id_libro' => $id_libro, 
            ':id' => $idusuariosesion, 
            ':fecha_inicio' => $fechaini, 
            ':fecha_fin' => $fechafin, 
            ':estado' => '1');
            return ejecutarConsulta($sql, $parametros);
        }
        
        
        
        //luego descativa la disponibilidad del libro
        public function cambiarestadodelibro($id_libro , $estado){ 
            $sql = "UPDATE libros SET estado = :estado WHERE id_libro = :id_libro";
            $parametros = [
                ':estado' => $estado,
                ':id_libro' => $id_libro
            ];
            return ejecutarConsulta($sql, $parametros);
            
        }
        
        
        //funcion que verifica el acceso al sistema
        
        public function verificar($correo, $clavehash)
        {
            $sql = "SELECT *
            FROM usuarios
            WHERE correo = :correo AND contrasena = :contrasena";
            
            // Definir los parámetros de la consulta
            $parametros = [':correo' => $correo, ':contrasena' => $clavehash];
            
            // Ejecutar la consulta preparada
            return ejecutarConsulta($sql, $parametros);
        }
        

        
        




    }
    