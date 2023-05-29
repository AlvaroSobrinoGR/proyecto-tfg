<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

    $buscar_por = $_POST["buscar_por"];
    $contenido_busqueda = $_POST["contenido_busqueda"];
    $orden = $_POST["orden"];
    $tipo_orden = $_POST["tipo_orden"];
    
    $consulta = "SELECT * FROM descuentos";

    if(strlen($buscar_por)>0 && strlen($contenido_busqueda)>0){
        $consulta.=" WHERE ".$buscar_por." = '$contenido_busqueda'";
    }

    if(strlen($orden)>0 && strlen($tipo_orden)>0){
        $consulta.=" ORDER BY ".$orden." ".$tipo_orden;
    }

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
