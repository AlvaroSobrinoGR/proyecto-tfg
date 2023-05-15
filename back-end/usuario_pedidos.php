<?php

$email = $_POST['email'];

$conexion = new mysqli("localhost", "root", "", "tienda");

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

$conexion->close();
?>