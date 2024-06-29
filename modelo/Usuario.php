<?php
//incluir la conexion de base de datos
require_once "../config/Conexion.php";
class Usuario
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //metodo insertar regiustro
    public function insertar($nombre, $correo, $contrasena)
    {
        $sql = "INSERT INTO usuarios (nombre_completo, correo, contrasena, estado) 
            VALUES (:nombre_completo, :correo, :contrasena,'1')";

        $parametros = array(
            ':nombre_completo' => $nombre,
            ':correo' => $correo,
            ':contrasena' => $contrasena
        );

        return ejecutarConsulta($sql, $parametros);
    }


    public function desactivar($id_reserva)
    {
        $sql = "UPDATE reserva SET estado='0' WHERE id_reserva=:id_reserva";
        $parametros = array(':id_reserva' => $id_reserva);
        return ejecutarConsulta($sql, $parametros);
    }



    public function listar($idusuariosesion)
    {    
        $sql = "SELECT r.*, l.*, c.descripcion AS nombrecategoria
        FROM reserva AS r 
        INNER JOIN libros AS l ON l.id_libro = r.id_libro
        INNER JOIN usuarios AS u ON u.id = r.id
        INNER JOIN categoria AS c ON c.id_categoria = l.id_categoria
        WHERE r.id = :idusuariosesion AND r.estado = :estado";
        
        $parametros = array(':idusuariosesion' => $idusuariosesion, ':estado' => 1);

        return ejecutarConsulta($sql, $parametros);

    }

    public function obteneridlibro($id_reserva)
        {
            $sql = "SELECT id_libro
            FROM reserva
            WHERE id_reserva = :id_reserva";
            
            // Definir los parámetros de la consulta
            $parametros = [':id_reserva' => $id_reserva];
            
            // Ejecutar la consulta preparada
            return ejecutarConsultaSimpleFila($sql, $parametros);
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
