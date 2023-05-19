<?php
require_once 'envio_de_correos.php';

if(isset($_POST["email"])){
    $email = $_POST["email"];

    $conexion = new mysqli("localhost", "root", "", "tienda");

  $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
  $resultado = $conexion->query($consulta);
  $fila = $resultado->fetch_assoc();

  if ($resultado->num_rows > 0 && $fila["validada"] == 1) {

    $codgioConfirmacion = uniqid();

    $consulta = "UPDATE usuarios SET codigo = '$codgioConfirmacion'  WHERE email = '$email'";
  
    if ($conexion->query($consulta) == TRUE) {
        try {
            $resultado = enviarCorreo($email, "Recuperar cuenta", "En este enlace podras cambiar tu contraseñia y recuperar tu cuenta http://localhost/proyecto%20tfg/front-end/cambiar_contraseña.html?email=$email&hash=$codgioConfirmacion");
  
        } catch (Throwable $t) {
            echo "Ha ocurrido un error: " . $t->getMessage();
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
  
      

  } else {
  
      echo "La cuenta no existe";
  }

  $conexion->close();
}else{
    echo "Falta el email";
}

  
?>