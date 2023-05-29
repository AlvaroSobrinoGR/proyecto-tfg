<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

    $consulta = "SELECT * FROM descuentos";
    $resultado = $conexion->query($consulta);
    
    if($resultado->num_rows > 0){

        $json = "[";
        
        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
                $json .= "\"id_descuento\" : \"".$fila["id_descuento"]."\",";
                $json .= "\"porcentaje\" : \"".$fila["porcentaje"]."\",";
                $json .= "\"id_producto\" : \"".$fila["id_producto"]."\"";
                $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
    }else{
        echo "No hay resultados";
    }



$conexion->close();
?>
