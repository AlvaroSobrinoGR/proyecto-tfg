<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

    $consulta = "SELECT * FROM productos";
    $resultado = $conexion->query($consulta);
    
    if($resultado->num_rows > 0){

        $json = "[";
        
        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
                $json .= "\"id_producto\" : \"".$fila["id_producto"]."\",";
                $json .= "\"nombre\" : \"".$fila["nombre"]."\",";
                $json .= "\"descripcion\" : \"".addslashes($fila["descripcion"])."\",";
                $json .= "\"tipo\" : \"".$fila["tipo"]."\",";
                $json .= "\"stock\" : \"".$fila["stock"]."\",";
                $json .= "\"precio\" : \"".$fila["precio"]."\",";
                $json .= "\"activo\" : \"".$fila["activo"]."\"";
                $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
    }else{
        echo "No hay resultados";
    }



$conexion->close();
?>
