<?php

$conexion = new mysqli("localhost", "root", "", "tienda");

$email = $_POST['email'];
$asunto = $_POST['asunto'];
$consulta = $_POST['consulta'];
$fecha = $_POST['fecha'];

$sql = "SELECT id_usuario FROM usuarios WHERE email = '$email'";

$resultado = $conexion->query($sql);

$id_usuario = $resultado-> fetch_assoc()["id_usuario"];

$estado = "espera";
  
$sql = "INSERT INTO consultas (id_usuario, asunto, consulta, estado, fecha) VALUES ('$id_usuario', '$asunto', '$consulta', '$estado', '$fecha')";
/*
espera: aun no ha sido atendida
trabajando: se esta trabajando en ella
finalizada: consulta cerrada
 */
if ($conexion->query($sql) == TRUE) {
  echo "Consulta creada";
} else {
  echo "Error al crear la consulta: ";
}
  
$conexion->close();
?>

