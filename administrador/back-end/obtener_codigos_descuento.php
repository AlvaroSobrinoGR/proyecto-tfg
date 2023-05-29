<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

    $consulta = "SELECT * FROM codigo_descuento";
    $resultado = $conexion->query($consulta);
    
    if($resultado->num_rows > 0){

        $json = "[";
        
        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
                $json .= "\"id_cupon\" : \"".$fila["id_cupon"]."\",";
                $json .= "\"porcentaje\" : \"".$fila["porcentaje"]."\",";
                $json .= "\"estado\" : \"".$fila["estado"]."\"";
                $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
    }else{
        echo "No hay resultados";
    }



$conexion->close();
?>
