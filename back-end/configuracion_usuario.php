<?php
require_once 'envio_de_correos.php';
// Recoger datos del formulario
$tipo = $_POST['tipo'];

if ($tipo === "configuracion") {
  // Recoger datos del formulario para configuración
  $nombre = $_POST['nombre'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];

  // Imprimir los datos recogidos para configuración
  echo "Nombre: " . $nombre . "<br>";
  echo "Dirección: " . $direccion . "<br>";
  echo "Teléfono: " . $telefono . "<br>";
} else {
  // Recoger datos del formulario para cambiar contraseña
  $email = $_POST["email"];

  $conexion = new mysqli("localhost", "root", "", "tienda");

  $codgioConfirmacion = uniqid();

  $consulta = "UPDATE usuarios SET codigo = '$codgioConfirmacion'  WHERE email = '$email'";

  if ($conexion->query($consulta) == TRUE) {

      $resultado = enviarCorreo($email, "Cambiar contraseñia", "En este enlace podras cambiar tu contraseñia http://localhost/proyecto%20tfg/front-end/cambiar_contraseña.html?email=$email&hash=$codgioConfirmacion");

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

}
?>