<?php

    $conexion = new mysqli("localhost", "root", "", "tienda");

  // Recoger los datos del formulario
  $email = $_POST['email'];
  $nombre = $_POST['nombre'];
  $consulta = $_POST['consulta'];
  $estado = 0; // Valor por defecto para el estado
  
  // Insertar los datos en la tabla consultas
  $sql = "INSERT INTO consultas (email, nombre, consulta, estado) VALUES ('$email', '$nombre', '$consulta', $estado)";
  if ($conexion->query($sql) == TRUE) {
    echo "Consulta creada";
    } else {
    echo "Error al crear la consulta: " . $conexion->error;
    }
  
  // Cerrar la conexión
  $conexion->close();
?>