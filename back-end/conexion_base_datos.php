<?php


function conexionBaseDatos(){
    try {
        // Intentar conexión con el primer host
        //Esta es la conexion con XAMPP
        //Esta es la conexion con XAMPP
        //Esta es la conexion con XAMPP
        $conexion= new mysqli("localhost", "root", "", "tienda");
        mysqli_set_charset($conexion, "utf8");
    
        // Verificar si se pudo conectar
        if ($conexion->connect_error) {
            throw new Exception("Error en la conexión con el primer host: " . $conexion->connect_error);
        }
    } catch (Exception $e1) {
        try {
            // Si la conexión con el primer host falla, intentar con el segundo host
            $conexion = new mysqli("sql206.epizy.com", "epiz_34247896", "sepv7ZqbF9CP", "epiz_34247896_tienda");
            mysqli_set_charset($conexion, "utf8");
    
            // Verificar si se pudo conectar
            if ($conexion->connect_error) {
                throw new Exception("Error en la conexión con el segundo host: " . $conexion->connect_error);
            }
        } catch (Exception $e2) {
            // Si la conexión con ambos hosts falla, mostrar un mensaje de error
            die("Error: No se pudo conectar a ninguna base de datos. Detalles: " . $e2->getMessage());
        }
    }
    return $conexion;
}
?>
