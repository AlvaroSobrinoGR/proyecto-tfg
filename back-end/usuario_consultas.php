<?php

//$email = $_POST['email'];
$email = "estudiosalvaroestudios@gmail.com";

$conexion = new mysqli("localhost", "root", "", "tienda");

$consulta = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = $conexion->query($consulta);
$id_usuario = "";

while ($fila = $resultado-> fetch_assoc()){
    $id_usuario = $fila["id_usuario"];
}


$consulta = "SELECT *  FROM consultas WHERE id_usuario = '$id_usuario'";
$resultado = $conexion->query($consulta);


$json = "[";

while ($fila = $resultado-> fetch_assoc()){
    $json .= "{";
    $json .= "\"id_consulta\" : \"".$fila["id_consulta"]."\",";
    $json .= "\"asunto\" : \"".$fila["asunto"]."\",";
    $json .= "\"consulta\" : \"".$fila["consulta"]."\",";
    $json .= "\"estado\" : \"".$fila["estado"]."\",";//1 hay stock 0 no hay stock
    $json .= "\"fecha\" : \"".$fila["fecha"]."\"";
    $json .= "},";
}
$json = substr($json, 0, strlen($json)-1);
echo $json."]";

$conexion->close();
?>