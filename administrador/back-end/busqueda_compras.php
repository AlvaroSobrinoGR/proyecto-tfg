<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

    $buscar_por = $_POST["buscar_por"];
    $contenido_busqueda = $_POST["contenido_busqueda"];
    $orden = $_POST["orden"];
    $tipo_orden = $_POST["tipo_orden"];

    $consulta = "SELECT * FROM compra";
    
    if (strlen($buscar_por) > 0 && strlen($contenido_busqueda) > 0) {
        if ($buscar_por == "id_producto" || $buscar_por == "cantidad" || $buscar_por == "precio_unidad" || $buscar_por == "precio_total_productos" || $buscar_por == "porcentaje_descuento" || $buscar_por == "total_tras_descuento") {
            if($buscar_por == "precio_total_productos"){
                $consulta .= " WHERE id_compra IN (SELECT cp.id_compra FROM compra_productos cp WHERE cp." . $buscar_por . " = 'precio_total')";
            }else{
                $consulta .= " WHERE id_compra IN (SELECT cp.id_compra FROM compra_productos cp WHERE cp." . $buscar_por . " = '$contenido_busqueda')";
            }
            
        } else {
            $consulta .= " WHERE " . $buscar_por . " = '$contenido_busqueda'";
        }
    }

    if (strlen($orden) > 0 && strlen($tipo_orden) > 0) {
        $consulta .= " ORDER BY " . $orden . " " . $tipo_orden;
    }
   
    $resultado = $conexion->query($consulta);
    if($resultado->num_rows > 0){
        $json = "[";
        
        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
                $json .= "\"id_compra\" : \"".$fila["id_compra"]."\",";
                $json .= "\"id_usuario\" : \"".$fila["id_usuario"]."\",";
                $json .= "\"id_datos_comprador\" : \"".$fila["id_datos_comprador"]."\",";
                $json .= "\"tiempo_local_compra\" : \"".$fila["tiempo_local_compra"]."\",";
                $json .= "\"zulu_time_compra\" : \"".$fila["zulu_time_compra"]."\",";
                $json .= "\"id_orden_compra\" : \"".$fila["id_orden_compra"]."\",";
                $json .= "\"id_pagador\" : \"".$fila["id_pagador"]."\",";
                $json .= "\"email_pagador\" : \"".$fila["email_pagador"]."\",";
                $json .= "\"nombre_apellido_pagador\" : \"".$fila["nombre_apellido_pagador"]."\",";
                $json .= "\"precio_total\" : \"".$fila["precio_total"]."\",";
                $json .= "\"id_cupon\" : \"".$fila["id_cupon"]."\",";
                $json .= "\"total_tras_codigo\" : \"".$fila["total_tras_codigo"]."\",";
                $json .= "\"porcentaje_iva\" : \"".$fila["porcentaje_iva"]."\",";
                $json .= "\"total_final_con_iva\" : \"".$fila["total_final_con_iva"]."\",";
                $json .= "\"productos\" : [";

                $id_compra = $fila["id_compra"];
                $consulta_interna = "SELECT * FROM compra_productos WHERE id_compra = '$id_compra'";
                $resultado_interno = $conexion->query($consulta_interna);
                if($resultado_interno->num_rows > 0){
                    while ($fila_interna = $resultado_interno-> fetch_assoc()){
                        $json .= "{";
                        $json .= "\"id_producto\" : \"" . $fila_interna["id_producto"] . "\",";
                        $json .= "\"cantidad\" : \"" . $fila_interna["cantidad"] . "\",";
                        $json .= "\"precio_unidad\" : \"" . $fila_interna["precio_unidad"] . "\",";
                        $json .= "\"precio_total\" : \"" . $fila_interna["precio_total"] . "\",";
                        $json .= "\"porcentaje_descuento\" : \"" . $fila_interna["porcentaje_descuento"] . "\",";
                        $json .= "\"total_tras_descuento\" : \"" . $fila_interna["total_tras_descuento"] . "\""; 
                        $json .= "},";               
                    }
                 $json = substr($json, 0, strlen($json)-1);
                $json .= "]";
                $json .= "},";
                }
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
    }else{
        echo "No hay resultados";
    }

$conexion->close();

?>