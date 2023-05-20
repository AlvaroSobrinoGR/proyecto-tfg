<?php
require_once 'envio_de_correos.php';
require_once 'conexion_base_datos.php';
// Recoger datos del formulario
$tipo = $_POST['tipo'];

$conexion = conexionBaseDatos();

if($tipo === "cargar"){ //cargar los datos
  $email = $_POST['email'];

  $consulta = "SELECT * FROM usuarios  WHERE email = '$email'";
  
  if ($conexion->query($consulta) == TRUE) {
    $resultado = $conexion->query($consulta);

    $json = "[";

    $fila = $resultado-> fetch_assoc();
    $json .= "{";
    
    $id_datos = $fila["id_datos"];
    $json .= "\"novedades\" : \"".$fila["novedades"]."\",";//1 hay stock 0 no hay stock

    if(strlen($id_datos) > 0){
      $consulta = "SELECT * FROM datos_usuario  WHERE id_datos = '$id_datos'";
      if ($conexion->query($consulta) == TRUE) {
        $resultado = $conexion->query($consulta);
        $fila = $resultado-> fetch_assoc();
        $json .= "\"nombre\" : \"".$fila["nombre_apellido"]."\",";
        $json .= "\"direccion\" : \"".$fila["direccion"]."\",";
        $json .= "\"telefono\" : \"".($fila["telefono"]!=0?$fila["telefono"]:"")."\"";
      }
    }else{
      $json .= "\"nombre\" : \"\",";
      $json .= "\"direccion\" : \"\",";
      $json .= "\"telefono\" : \"\"";
    }

    $json .= "}";

    echo $json."]";

  }else{
    echo "No que consiguio insertar los datos en las tablas: " . $conexion->error;
  }

}else if ($tipo === "configuracion") { //cambiar los datos
  $email = $_POST['email'];
  $nombre = $_POST['nombre'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];
  $novedades = $_POST['novedades'];

  //primero ver los datos en datos_usuario
  $id_datos;
  $consulta = "SELECT id_datos FROM datos_usuario WHERE nombre_apellido='$nombre' AND direccion='$direccion' AND telefono='$telefono'";
  $resultado = $conexion->query($consulta);

  if ($resultado->num_rows > 0) {
      // Los datos ya están registrados, obtener el ID
      $row = $resultado->fetch_assoc();
      $id_datos = $row['id_datos'];
  } else {
      // Los datos no están registrados, insertar nueva fila
      $consulta = "INSERT INTO datos_usuario (nombre_apellido, direccion, telefono) VALUES ('$nombre', '$direccion', '$telefono')";
      if ($conexion->query($consulta) === TRUE) {
        $id_datos = mysqli_insert_id($conexion);
      } else {
          echo "Error: " . $consulta . "<br>" . $conexion->error;
      }
  }
  //insertamos el nuevo id de datos_usuario al usario
  if($id_datos != "ya existe"){
    $consulta = "UPDATE usuarios SET id_datos = '$id_datos' WHERE email = '$email';";

    if ($conexion->query($consulta) == TRUE) {
      echo "los datos se han actualizado";
    }else{
      echo "los datos no se han actualizado, ha surgido un error";
    }  
  }


  $consulta = "UPDATE usuarios SET id_datos='$id_datos', novedades = '$novedades' WHERE email = '$email';";

  if ($conexion->query($consulta) == TRUE) {
    echo "los datos se han actualizado";
  }else{
    echo "los datos no se han actualizado, ha surgido un error";
  }

} else if($tipo === "configuracionCarrito"){

  $email = $_POST['email'];
  $nombre = $_POST['nombre'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];

  

  //primero ver los datos en datos_usuario
  $id_datos = "ya existe";
  $consulta = "SELECT id_datos FROM datos_usuario WHERE nombre_apellido='$nombre' AND direccion='$direccion' AND telefono='$telefono'";
  $resultado = $conexion->query($consulta);

  if ($resultado->num_rows > 0) {
      // Los datos ya están registrados, obtener el ID
      $id_datos = "ya existe";
  } else {
      // Los datos no están registrados, insertar nueva fila
      $consulta = "INSERT INTO datos_usuario (nombre_apellido, direccion, telefono) VALUES ('$nombre', '$direccion', '$telefono')";
      if ($conexion->query($consulta) === TRUE) {
        $id_datos = mysqli_insert_id($conexion);
      } else {
          echo "Error: " . $consulta . "<br>" . $conexion->error;
      }
  }
  //insertamos el nuevo id de datos_usuario al usario
  if($id_datos != "ya existe"){
    $consulta = "UPDATE usuarios SET id_datos = '$id_datos' WHERE email = '$email';";

    if ($conexion->query($consulta) == TRUE) {
      echo "los datos se han actualizado";
    }else{
      echo "los datos no se han actualizado, ha surgido un error";
    }  
  }
  
}else {  //comtrasenia
  // Recoger datos del formulario para cambiar contraseña
  $email = $_POST["email"];

  $codgioConfirmacion = uniqid();

  $consulta = "UPDATE usuarios SET codigo = '$codgioConfirmacion'  WHERE email = '$email'";

  if ($conexion->query($consulta) == TRUE) {

    if(strpos($conexion->host_info,"localhost")){
      $resultado = enviarCorreo($email, "Cambiar contraseñia", "En este enlace podras cambiar tu contraseñia http://localhost/proyecto%20tfg/front-end/cambiar_contraseña.html?email=$email&hash=$codgioConfirmacion");
    }else{
      $resultado = enviarCorreo($email, "Cambiar contraseñia", "En este enlace podras cambiar tu contraseñia http://simplyminimal.epizy.com/front-end/cambiar_contraseña.html?email=$email&hash=$codgioConfirmacion");
    }
      
      if($resultado=="enviado"){
          echo "exito";
      }else{
          $consulta = "UPDATE usuarios SET codigo = 0  WHERE email = '$email'";
          $conexion->query($consulta);
          echo "el email no se ha enviado";
      }

  } else {
      echo "No que consiguio insertar los datos en las tablas: " . $conexion->error;
  }

  $conexion->close();
}
?>