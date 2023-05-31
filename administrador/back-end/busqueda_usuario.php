<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

    $buscar_por = $_POST["buscar_por"];
    $contenido_busqueda = $_POST["contenido_busqueda"];
    $orden = $_POST["orden"];
    $tipo_orden = $_POST["tipo_orden"];

    $consulta = "SELECT u.id_usuario, u.email, u.validada,COALESCE(u.id_datos, '') AS id_datos, COALESCE(du.nombre_apellido, '') AS nombre_apellido,
                COALESCE(du.direccion, '') AS direccion, COALESCE(du.telefono, '') AS telefono, u.novedades
                FROM usuarios u
                LEFT JOIN datos_usuario du ON u.id_datos = du.id_datos";

    if(strlen($buscar_por)>0 && strlen($contenido_busqueda)>0){
        if($buscar_por=="id_datos" || $buscar_por=="nombre_apellido" || $buscar_por=="direccion" || $buscar_por=="telefono"){
            $consulta.=" WHERE du.".$buscar_por." = '$contenido_busqueda'";
        }else{
            $consulta.=" WHERE u.".$buscar_por." = '$contenido_busqueda'";
        }
        
    }

    if(strlen($orden)>0 && strlen($tipo_orden)>0){
        $consulta.=" ORDER BY ".$orden." ".$tipo_orden;
    }

    $resultado = $conexion->query($consulta);
    
    if($resultado->num_rows > 0){

        $json = "[";
        
        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
            $json .= "\"id_usuario\" : \"".$fila["id_usuario"]."\",";
            $json .= "\"email\" : \"".$fila["email"]."\",";
            $json .= "\"id_datos\" : \"".$fila["id_datos"]."\",";
            $json .= "\"nombre_apellido\" : \"".$fila["nombre_apellido"]."\",";
            $json .= "\"direccion\" : \"".$fila["direccion"]."\",";
            $json .= "\"telefono\" : \"".$fila["telefono"]."\",";
            $json .= "\"novedades\" : \"".$fila["novedades"]."\",";
            $json .= "\"validada\" : \"".$fila["validada"]."\"";
            $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
    }else{
        echo "No hay resultados";
    }

$conexion->close();

?>