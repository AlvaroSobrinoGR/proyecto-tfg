<?php

$conexion = new mysqli("localhost", "root", "", "tienda");

$email = $_POST['email'];
$nombre = $_POST['nombre'];
$consulta = $_POST['consulta'];
  
$sql = "INSERT INTO consultas (email, nombre, consulta, estado) VALUES ('$email', '$nombre', '$consulta', 0)";
if ($conexion->query($sql) == TRUE) {
  echo "Consulta creada";
} else {
  echo "Error al crear la consulta: ";
}
  
$conexion->close();
?>