<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();
    
    $consulta = "SELECT * FROM usuarios";
    $resultado = $conexion->query($consulta);
    
    if($resultado->num_rows > 0){

        $json = "[";
        
        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
            $json .= "\"id_usuario\" : \"".$fila["id_usuario"]."\",";
            $json .= "\"email\" : \"".$fila["email"]."\",";
            $json .= "\"id_datos\" : \"".$fila["id_datos"]."\",";

            $id_datos = $fila["id_datos"];
            $consulta_interna = "SELECT * FROM datos_usuario WHERE id_datos = '$id_datos'";
            $resultado_interno = $conexion->query($consulta_interna);
            if($resultado_interno->num_rows > 0){
                while ($fila_interna = $resultado_interno-> fetch_assoc()){
                    $json .= "\"nombre_apellido\" : \"".$fila_interna["nombre_apellido"]."\",";
                    $json .= "\"direccion\" : \"".$fila_interna["direccion"]."\",";
                    $json .= "\"telefono\" : \"".$fila_interna["telefono"]."\",";
                }
            }else{
                $json .= "\"nombre_apellido\" : \"\",";
                $json .= "\"direccion\" : \"\",";
                $json .= "\"telefono\" : \"\",";
            }

            $json .= "\"novedades\" : \"".$fila["novedades"]."\",";
            $json .= "\"validada\" : \"".$fila["validada"]."\"";
            $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
    }else{
        echo "";
    }



$conexion->close();
?>