<?php
//incluir la conexion de base de datos
require_once "../config/Conexion.php";
class Reserva
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //metodo insertar registro
    public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $area, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "INSERT INTO reserva (nombre, tipo_documento, num_documento, direccion, telefono, email, idareas, cargo, login, clave, imagen, condicion) 
            VALUES (:nombre, :tipo_documento, :num_documento, :direccion, :telefono, :email, :areas, :cargo, :login, :clave, :imagen, '1')";

        $parametros = array(
            ':nombre' => $nombre,
            ':tipo_documento' => $tipo_documento,
            ':num_documento' => $num_documento,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':email' => $email,
            ':areas' => $area,
            ':cargo' => $cargo,
            ':login' => $login,
            ':clave' => $clave,
            ':imagen' => $imagen
        );

        // Insertar el libros
        $id_reserva = ejecutarConsulta($sql, $parametros);
        // Insertar permisos
        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO reserva_permiso (idlibros, idpermiso) VALUES(:id_reserva, :permiso)";

            $parametros_detalle = array(':id_reserva' => $id_usuario, ':permiso' => $permisos[$num_elementos]);

            ejecutarConsulta($sql_detalle, $parametros_detalle) or $sw = false;

            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }

    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $area, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "UPDATE usuario SET nombre=:nombre, tipo_documento=:tipo_documento, num_documento=:num_documento, direccion=:direccion, 
            telefono=:telefono, email=:email, idareas=:areas, cargo=:cargo, login=:login, clave=:clave, imagen=:imagen WHERE idusuario=:idusuario";

        $parametros = array(
            ':nombre' => $nombre,
            ':tipo_documento' => $tipo_documento,
            ':num_documento' => $num_documento,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':email' => $email,
            ':areas' => $area,
            ':cargo' => $cargo,
            ':login' => $login,
            ':clave' => $clave,
            ':imagen' => $imagen,
            ':idusuario' => $idusuario
        );

        ejecutarConsulta($sql, $parametros);

        // Eliminar permisos asignados
        $sqldel = "DELETE FROM usuario_permiso WHERE idusuario=:idusuario";
        ejecutarConsulta($sqldel, array(':idusuario' => $idusuario));

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO usuario_permiso (idusuario, idpermiso) VALUES(:idusuario, :permiso)";

            $parametros_detalle = array(':idusuario' => $idusuario, ':permiso' => $permisos[$num_elementos]);

            ejecutarConsulta($sql_detalle, $parametros_detalle) or $sw = false;

            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }



    public function reservacion($id_libro) 
    {
        $sql = "INSERT INTO reserva (nombre, tipo_documento, num_documento, direccion, telefono, email, idareas, cargo, login, clave, imagen, condicion) 
            VALUES (:nombre, :tipo_documento, :num_documento, :direccion, :telefono, :email, :areas, :cargo, :login, :clave, :imagen, '1')";
        return ejecutarConsulta($sql, $parametros);
    }




    public function listar($filtrocategoria)
    {    
        $sql = "SELECT l.*, c.descripcion AS nombrecategoria
        FROM libros AS l
        INNER JOIN categoria AS c ON c.id_categoria = l.id_categoria
        WHERE l.estado = :estado AND l.id_categoria = :filtrocategoria";
        
        $parametros = array(':estado' => 1, ':filtrocategoria' => $filtrocategoria);

        return ejecutarConsulta($sql, $parametros);

    }



    public function listarcategorias()
    {    
        $sql = "SELECT *
        FROM categoria
        WHERE estado = :estado";
        
        $parametros = array(':estado' => 1);

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
