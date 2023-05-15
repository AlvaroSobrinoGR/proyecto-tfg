<?php


$conexion = new mysqli("localhost", "root", "", "tienda");

$email = $_POST['email'];
$id_pedido = $_POST["id_pedido"];

$consulta = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = $conexion->query($consulta);
$id_usuario = "";

while ($fila = $resultado-> fetch_assoc()){
    $id_usuario = $fila["id_usuario"];
}


$consulta = "SELECT *  FROM compra WHERE id_usuario = '$id_usuario' AND id_compra = '$id_pedido'";
$resultado = $conexion->query($consulta);

if($resultado->num_rows >0 ){
    echo "bien";
}else{
    echo "mal";
}

$conexion->close();
?>