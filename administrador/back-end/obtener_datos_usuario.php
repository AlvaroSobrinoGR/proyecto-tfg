<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();
    
    $consulta = "SELECT * FROM datos_usuario";
    $resultado = $conexion->query($consulta);
    
    if($resultado->num_rows > 0){

        $json = "[";
        
        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
            $json .= "\"id_datos\" : \"".$fila["id_datos"]."\",";
            $json .= "\"nombre_apellido\" : \"".$fila["nombre_apellido"]."\",";
            $json .= "\"direccion\" : \"".$fila["direccion"]."\",";
            $json .= "\"telefono\" : \"".$fila["telefono"]."\"";
            $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
    }else{
        echo "No hay resultados";
    }



$conexion->close();
?>