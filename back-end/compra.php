<?php

require_once 'envio_de_correos.php';
require_once 'pintar_factura_pedidos.php';

$conexion = new mysqli("localhost", "root", "", "tienda");

// recoger datos del usuario
$email = $_POST['email'];
$consulta = "SELECT id_usuario, id_datos FROM usuarios WHERE email='$email'";
$resultado;
$error = false;
$ultimo_id;
try{
  $resultado = $conexion->query($consulta);
  if($resultado->num_rows > 0){
  // si se encontró un usuario con ese email, se inserta la compra en la tabla "compra"
  $fila = $resultado->fetch_assoc();
  $id_usuario = $fila['id_usuario'];
  $id_datos_comprador = $fila['id_datos'];
  $tiempo_local_compra = $_POST['fechaActual'];
  $zulu_time_compra = $_POST['zulu_time_compra'];
  $id_orden_compra = $_POST['id_orden_compra'];
  $id_pagador = $_POST['id_pagador'];
  $email_pagador = $_POST['email_pagador'];
  $nombre_apellido_pagador = $_POST['nombre_apellido_pagador'];
  

  //hacer calculos de la compra

  $precio_total = 0;
  $id_cupon = $_POST["codigo_descuento"];
  $total_tras_cupon = 0;
  $porcentaje_iva = 21;
  $total_final_con_iva = 0;

    $productos_cantidades = $_POST["productos_cantidades"];
    $productos_cantidades = explode(";", $productos_cantidades);
    $productos_cantidades = array_slice($productos_cantidades, 1, -1);

    for ($i=0; $i < count($productos_cantidades); $i++) { 
        $temporal = explode("-", $productos_cantidades[$i]);//[0] producto [1] cantida
        $consulta = "SELECT * FROM productos WHERE id_producto = '$temporal[0]'";
        $resultado = $conexion->query($consulta);
        $fila = $resultado->fetch_assoc();
        $precio_total_prodcuto = (double)$fila["precio"]*(double)$temporal[1];
        //descuento del producto
        $porcentaje_descuento = 0;
        $consulta_descuento = "SELECT * FROM descuentos WHERE id_producto = $temporal[0]";
        $resultado_descuento = $conexion->query($consulta_descuento);
        if ($fila_descuento = $resultado_descuento->fetch_assoc()) {
          $porcentaje_descuento = $fila_descuento["porcentaje"];
        }
        $precio_total += $precio_total_prodcuto-($precio_total_prodcuto*$porcentaje_descuento/100);
    }
  
    $consulta = "SELECT * FROM codigo_descuento WHERE BINARY id_cupon = '$id_cupon'";
    $resultado = $conexion->query($consulta);

    if($resultado->num_rows > 0) {
      $fila = $resultado->fetch_assoc();
      if($fila["estado"] == 1){
        $total_tras_cupon = $precio_total-($precio_total*(double)$fila["porcentaje"]/100);
      }else{
        $id_cupon = "";
        $total_tras_cupon = $precio_total;
      }
    }else{
      $id_cupon = "";
      $total_tras_cupon = $precio_total;
    }

    $total_final_con_iva = $total_tras_cupon+($total_tras_cupon*$porcentaje_iva/100);

    
    $tolerancia = 0.2;
    if (abs($_POST["importe_total_paypal"] - $total_final_con_iva) <= $tolerancia) {// Los números son iguales con una tolerancia de 0.1 decimales

    } else {// Los números son diferentes
      throw new Exception('Los precios son diferentes');
    }

    $conexion->autocommit(false);
    $consulta;
    if(strlen($id_cupon)>0){
      $consulta = "INSERT INTO compra (id_usuario, id_datos_comprador, tiempo_local_compra, zulu_time_compra, id_orden_compra, id_pagador, email_pagador, nombre_apellido_pagador, precio_total, id_cupon, total_tras_codigo, porcentaje_iva, total_final_con_iva)
      VALUES ('$id_usuario', '$id_datos_comprador', '$tiempo_local_compra', '$zulu_time_compra', '$id_orden_compra', '$id_pagador', '$email_pagador', '$nombre_apellido_pagador', '$precio_total','$id_cupon','$total_tras_cupon','$porcentaje_iva','$total_final_con_iva')";
    
    }else{
      $consulta = "INSERT INTO compra (id_usuario, id_datos_comprador, tiempo_local_compra, zulu_time_compra, id_orden_compra, id_pagador, email_pagador, nombre_apellido_pagador, precio_total, total_tras_codigo, porcentaje_iva, total_final_con_iva)
      VALUES ('$id_usuario', '$id_datos_comprador', '$tiempo_local_compra', '$zulu_time_compra', '$id_orden_compra', '$id_pagador', '$email_pagador', '$nombre_apellido_pagador', '$precio_total','$total_tras_cupon','$porcentaje_iva','$total_final_con_iva')";
    }
    
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
            $precio_unidad = (double)$fila["precio"];
            $precio_total = $precio_unidad*$temporal[1];

            //descuento
            $porcentaje_descuento = 0;
            $consulta_descuento = "SELECT * FROM descuentos WHERE id_producto = $temporal[0]";
            $resultado_descuento = $conexion->query($consulta_descuento);
            $descuento;
            if ($fila_descuento = $resultado_descuento->fetch_assoc()) {
              $porcentaje_descuento = $fila_descuento["porcentaje"];
            }

            $total_tras_descuento = $precio_total-($precio_total*$porcentaje_descuento/100);



            $consulta = "INSERT INTO compra_productos (id_compra, id_producto, cantidad, precio_unidad, precio_total, porcentaje_descuento, total_tras_descuento) 
            VALUES ('$ultimo_id', '$temporal[0]', '$temporal[1]', '$precio_unidad ','$precio_total','$porcentaje_descuento','$total_tras_descuento')";

            $conexion->query($consulta);
            $stock = (int)$fila["stock"];
            $stock = $stock-$temporal[1];
            $consulta = "UPDATE productos SET stock = '$stock' WHERE id_producto = '$temporal[0]'";
            $conexion->query($consulta);

        }

          $conexion->autocommit(true);
  }

}catch (Throwable $t) {
  $conexion->rollback(); //devuelve la base de datos al estaod anterior a las operacions
  echo $t->getMessage();
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

      $id_datos = $fila['id_datos_comprador'];
      $consulta_usuario = "SELECT * FROM datos_usuario WHERE id_datos = $id_datos";
      $resultado_usuario = $conexion->query($consulta_usuario);
      $fila_usuario = $resultado_usuario->fetch_assoc();

      $nombre_apellido_comprador = $fila_usuario['nombre_apellido'];
      $direccion_comprador = $fila_usuario['direccion'];
      $telefono_comprador = $fila_usuario['telefono'];


      $tiempo_local_compra = $fila['tiempo_local_compra'];
      $zulu_time_compra = $fila['zulu_time_compra'];
      $id_orden_compra = $fila['id_orden_compra'];
      $id_pagador = $fila['id_pagador'];
      $email_pagador = $fila['email_pagador'];
      $nombre_apellido_pagador = $fila['nombre_apellido_pagador'];
      $importe_total = $fila['total_final_con_iva'];
      enviarCorreo($email, "Compra realizada",pintarFactureaPedidos($id_compra, "Compra"));
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
  $importe_total_email = $_POST['importe_total_email'];
  enviarCorreo($email, "ERROR DE COMPRA", 
  "ha surgido alguna clase de error con la compra, se le mandara un email con los datos oportunos a esta. si ve que se le ha hecho un cobor o algun otro problema con esta compra comuniquese con estos datos atraves de nuestras consultas<br>
  email del usuario que realiza la comra: $email<br>
  fecha local de la compra: $fechaActual<br>
  hora zulu de la comra: $zulu_time_compra<br>
  id orden de compra: $id_orden_compra<br>
  id de lpagador: $id_pagador<br>
  email del pagador: $email_pagador<br>
  nombre y apellido del pagador: $nombre_apellido_pagador<br>
  importe total: $importe_total_email<br>
  ");

}

$conexion->close();
//decir que se ha enviado un email al usuario con los datos recogidos de la compra por si surgiera algun problema y pueda ponere en contacto con la pagina
?>