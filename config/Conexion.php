<?php



require_once "global.php";

try {
    // Crear una instancia de la clase PDO
    $conexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_ENCODE, DB_USERNAME, DB_PASSWORD);
    
    // Configurar el manejo de errores para lanzar excepciones en lugar de mostrar advertencias
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejar errores de conexión
    die("Falló en la conexión con la base de datos: " . $e->getMessage());
}

// Función para ejecutar consultas preparadas
function ejecutarConsulta($sql, $parametros = []) {

    global $conexion;
    
    try {

        // Crear una copia de la consulta original
        $sqlWithParams = $sql;
        
        // Reemplazar los placeholders con los valores correspondientes
        foreach ($parametros as $key => $value) {
            $sqlWithParams = str_replace($key, "'$value'", $sqlWithParams);
        }
        
        // Imprimir la consulta completa
        //echo "Consulta con parámetros: " . $sqlWithParams;

        //esto lanza consulta

        $stmt = $conexion->prepare($sql);
        $stmt->execute($parametros);
        
        return $stmt;
    } catch (PDOException $e) {
        die("Error en la consulta: " . $e->getMessage());
    }
}


// Función para ejecutar una consulta y retornar una fila como array asociativo
function ejecutarConsultaSimpleFila($sql, $parametros = []) {
    $stmt = ejecutarConsulta($sql, $parametros);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Función para ejecutar una consulta y retornar el ID generado por AUTO_INCREMENT

 function ejecutarConsulta_retornarID($sql, $parametros = []) {
     global $conexion;
     $stmt = ejecutarConsulta($sql, $parametros);
     return $conexion->lastInsertId();
 }

// Función para limpiar una cadena (no es necesario en PDO, pero puedes mantenerla si prefieres)
function limpiarCadena($str) {
    global $conexion;
    $str = trim($str);
    return htmlspecialchars($str);
}


?>
