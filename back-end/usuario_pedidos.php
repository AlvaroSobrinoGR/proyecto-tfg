<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

if(isset($_POST['email'])){
    $email = $_POST['email'];


    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($consulta);
    $id_usuario = "";
    
    while ($fila = $resultado-> fetch_assoc()){
        $id_usuario = $fila["id_usuario"];
    }
    
    
    $consulta = "SELECT *  FROM compra WHERE id_usuario = '$id_usuario'";
    $resultado = $conexion->query($consulta);
    
    
    $json = "[";
    
    while ($fila = $resultado-> fetch_assoc()){
        $json .= "{";
        $json .= "\"id_compra\" : \"".$fila["id_compra"]."\",";
        $json .= "\"precio\" : \"".$fila["total_final_con_iva"]."\",";
        $json .= "\"fecha\" : \"".$fila["tiempo_local_compra"]."\"";
        $json .= "},";
    }
    $json = substr($json, 0, strlen($json)-1);
    echo $json."]";
}else{
    echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
}



$conexion->close();
?>