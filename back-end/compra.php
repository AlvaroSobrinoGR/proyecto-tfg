<?php

$conexion = new mysqli("localhost", "root", "", "tienda");

// recoger datos del usuario
$email = $_POST['email'];
$consulta = "SELECT id_usuario, nombre, direccion, telefono FROM usuarios WHERE email='$email'";
$resultado = $conexion->query($consulta);

// si se encontró un usuario con ese email, se inserta la compra en la tabla "compra"
if (mysqli_num_rows($resultado) > 0) {
  $fila = $resultado->fetch_assoc();
  $id_usuario = $fila['id_usuario'];
  $nombre_apellido_comprador = $fila['nombre'];
  $direccion_comprador = $fila['direccion'];
  $telefono_comprador = $fila['telefono'];
  $tiempo_local_compra = $_POST['fechaActual'];
  $zulu_time_compra = $_POST['zulu_time_compra'];
  $id_orden_compra = $_POST['id_orden_compra'];
  $id_pagador = $_POST['id_pagador'];
  $email_pagador = $_POST['email_pagador'];
  $nombre_apellido_pagador = $_POST['nombre_apellido_pagador'];
  $importe_total = $_POST['importe_total'];

  $consulta = "INSERT INTO compra (id_usuario, nombre_apellido_comprador, direccion_comprador, telefono_comprador, tiempo_local_compra, zulu_time_compra, id_orden_compra, id_pagador, email_pagador, nombre_apellido_pagador, importe_total)
  VALUES ('$id_usuario', '$nombre_apellido_comprador', '$direccion_comprador', '$telefono_comprador', '$tiempo_local_compra', '$zulu_time_compra', '$id_orden_compra', '$id_pagador', '$email_pagador', '$nombre_apellido_pagador', '$importe_total')";
  
    if ($conexion->query($consulta)) {
      $ultimo_id = mysqli_insert_id($conexion);
      $productos_cantidades = $_POST["productos_cantidades"];
      $productos_cantidades = explode(";", $productos_cantidades);
      $productos_cantidades = array_slice($productos_cantidades, 1, -1);
      for ($i=0; $i < count($productos_cantidades); $i++) { 
          $temporal = explode("-", $productos_cantidades[$i]);//[0] producto [1] cantida
          $consulta = "SELECT * FROM productos WHERE id_producto = '$temporal[0]'";
          $resultado = $conexion->query($consulta);
          $fila = $resultado->fetch_assoc();
          $precio = $fila["precio"];
          $consulta = "INSERT INTO compra_productos (id_compra, id_producto, cantidad, precio) VALUES ('$ultimo_id', '$temporal[0]', '$temporal[1]', '$precio')";
          $conexion->query($consulta);
        }
    }

} else {
  echo "No se ha encontrado ningún usuario con ese email";
}

$conexion->close();
//decir que se ha enviado un email al usuario con los datos recogidos de la compra por si surgiera algun problema y pueda ponere en contacto con la pagina
?>