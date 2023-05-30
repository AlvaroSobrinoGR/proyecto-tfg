<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

    $consulta = "SELECT * FROM incidencias";
    $resultado = $conexion->query($consulta);
    
    if($resultado->num_rows > 0){

        $json = "[";
        
        while ($fila = $resultado-> fetch_assoc()){
            $json .= "{";
                $json .= "\"id_incidencia\" : \"".$fila["id_incidencia"]."\",";
                $json .= "\"id_empleado\" : \"".$fila["id_empleado"]."\",";
                $json .= "\"id_compra\" : \"".$fila["id_compra"]."\",";
                $json .= "\"asunto\" : \"".addslashes($fila["asunto"])."\",";
                $json .= "\"consulta\" : \"".addslashes($fila["consulta"])."\",";
                $json .= "\"estado\" : \"".$fila["estado"]."\",";
                $json .= "\"fecha\" : \"".$fila["fecha"]."\"";
                $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
    }else{
        echo "No hay resultados";
    }



$conexion->close();
?>
