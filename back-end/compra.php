<?php

require_once 'envio_de_correos.php';

$conexion = new mysqli("localhost", "root", "", "tienda");

// recoger datos del usuario
$email = $_POST['email'];
$consulta = "SELECT id_usuario, nombre, direccion, telefono FROM usuarios WHERE email='$email'";
$resultado = $conexion->query($consulta);
$error = false;
$ultimo_id;
try{
  $conexion->query($consulta);


  // si se encontró un usuario con ese email, se inserta la compra en la tabla "compra"
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

    $conexion->autocommit(false);

    $consulta = "INSERT INTO compra (id_usuario, nombre_apellido_comprador, direccion_comprador, telefono_comprador, tiempo_local_compra, zulu_time_compra, id_orden_compra, id_pagador, email_pagador, nombre_apellido_pagador, importe_total)
    VALUES ('$id_usuario', '$nombre_apellido_comprador', '$direccion_comprador', '$telefono_comprador', '$tiempo_local_compra', '$zulu_time_compra', '$id_orden_compra', '$id_pagador', '$email_pagador', '$nombre_apellido_pagador', '$importe_total')";
    
      $conexion->query($consulta);
        $ultimo_id = mysqli_insert_id($conexion);
        $productos_cantidades = $_POST["productos_cantidades"];
        $productos_cantidades = explode(";", $productos_cantidades);
        $productos_cantidades = array_slice($productos_cantidades, 1, -1);

        for ($i=0; $i < count($productos_cantidades); $i++) { 
            $temporal = explode("-", $productos_cantidades[$i]);//[0] producto [1] cantida
            $consulta = "SELECT * FROM productos WHERE id_producto = '$temporal[0]'";
            $resultado;
            $conexion->query($consulta);
            $resultado = $conexion->query($consulta);
            $fila = $resultado->fetch_assoc();
            $precio = $fila["precio"];
            $consulta = "INSERT INTO compra_productos (id_compra, id_producto, cantidad, precio) VALUES ('$ultimo_id', '$temporal[0]', '$temporal[1]', '$precio')";
            $conexion->query($consulta);
            $stock = $fila["stock"];
            $stock = $stock-$temporal[1];
            $consulta = "UPDATE productos SET stock = '$stock' WHERE id_producto = '$temporal[0]'";
            $conexion->query($consulta);
          }

          $conexion->autocommit(true);

}catch (Throwable $t) {
  $conexion->rollback(); //devuelve la base de datos al estaod anterior a las operacions
  ERROR($_POST['email']);
  $error = true;
}

if(!$error){
  try{
    $consulta = "SELECT * FROM compra WHERE id_compra='$ultimo_id'";
    if($conexion->query($consulta)){
      $resultado = $conexion->query($consulta);
      $fila = $resultado->fetch_assoc();
      $id_compra = $fila['id_compra'];
      $id_usuario = $fila['id_usuario'];
      $nombre_apellido_comprador = $fila['nombre_apellido_comprador'];
      $direccion_comprador = $fila['direccion_comprador'];
      $telefono_comprador = $fila['telefono_comprador'];
      $tiempo_local_compra = $fila['tiempo_local_compra'];
      $zulu_time_compra = $fila['zulu_time_compra'];
      $id_orden_compra = $fila['id_orden_compra'];
      $id_pagador = $fila['id_pagador'];
      $email_pagador = $fila['email_pagador'];
      $nombre_apellido_pagador = $fila['nombre_apellido_pagador'];
      $importe_total = $fila['importe_total'];
      enviarCorreo($email, "Compra realizada",
      "has echo una compra<br>
      id de la compra: $id_compra <br>
      email del usuario que realiza la comra: $email<br>
      id del usuario que realiza la comra: $id_usuario <br>
      nombre del usuario que realiza la comra: $nombre_apellido_comprador <br>
      direccion del usuario que realiza la comra: $direccion_comprador<br>
      telefono del usuario que realiza la comra: $telefono_comprador<br>
      fecha local de la compra: $tiempo_local_compra<br>
      hora zulu de la comra: $zulu_time_compra<br>
      id orden de compra: $id_orden_compra<br>
      id de lpagador: $id_pagador<br>
      email del pagador: $email_pagador<br>
      nombre y apellido del pagador: $nombre_apellido_pagador<br>
      importe total: $importe_total<br>
    ");
    }else{
      $conexion->rollback(); //devuelve la base de datos al estaod anterior a las operacions
      ERROR($_POST['email']);
    }
    
    
  }catch (Throwable $t) {
  $conexion->rollback(); //devuelve la base de datos al estaod anterior a las operacions
  ERROR($_POST['email']);
  }
}

function ERROR($email){
  echo "ha surgido alguna clase de error con la compra, se le mandara un email con los datos oportunos a esta. si ve que se le ha hecho un cobor o algun otro problema con esta compra comuniquese con estos datos atraves de nuestras consultas";
  $fechaActual = $_POST['fechaActual'];
  $zulu_time_compra = $_POST['zulu_time_compra'];
  $id_orden_compra = $_POST['id_orden_compra'];
  $id_pagador = $_POST['id_pagador'];
  $email_pagador = $_POST['email_pagador'];
  $nombre_apellido_pagador = $_POST['nombre_apellido_pagador'];
  $importe_total = $_POST['importe_total'];
  enviarCorreo($email, "ERROR DE COMPRA", 
  "ha surgido alguna clase de error con la compra, se le mandara un email con los datos oportunos a esta. si ve que se le ha hecho un cobor o algun otro problema con esta compra comuniquese con estos datos atraves de nuestras consultas<br>
  email del usuario que realiza la comra: $email<br>
  fecha local de la compra: $fechaActual<br>
  hora zulu de la comra: $zulu_time_compra<br>
  id orden de compra: $id_orden_compra<br>
  id de lpagador: $id_pagador<br>
  email del pagador: $email_pagador<br>
  nombre y apellido del pagador: $nombre_apellido_pagador<br>
  importe total: $importe_total<br>
  ");

}

$conexion->close();
//decir que se ha enviado un email al usuario con los datos recogidos de la compra por si surgiera algun problema y pueda ponere en contacto con la pagina
?>