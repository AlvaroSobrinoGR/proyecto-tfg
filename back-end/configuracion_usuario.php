<?php
require_once 'envio_de_correos.php';
// Recoger datos del formulario
$tipo = $_POST['tipo'];

$conexion = new mysqli("localhost", "root", "", "tienda");

if($tipo === "cargar"){ //cargar los datos
  $email = $_POST['email'];

  $consulta = "SELECT * FROM usuarios  WHERE email = '$email'";
  
  if ($conexion->query($consulta) == TRUE) {
    $resultado = $conexion->query($consulta);

    $json = "[";

    $fila = $resultado-> fetch_assoc();
    $json .= "{";
    $json .= "\"nombre\" : \"".$fila["nombre"]."\",";
    $json .= "\"direccion\" : \"".$fila["direccion"]."\",";
    $json .= "\"telefono\" : \"".$fila["telefono"]."\",";
    $json .= "\"novedades\" : \"".$fila["novedades"]."\"";//1 hay stock 0 no hay stock
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

  $consulta = "UPDATE usuarios SET nombre = '$nombre', direccion = '$direccion', telefono = '$telefono', novedades = '$novedades' WHERE email = '$email';";

  if ($conexion->query($consulta) == TRUE) {
    echo "los datos se han actualizado";
  }else{
    echo "los datos no se han actualizado, ha surgido un error";
  }

} else {  //comtrasenia
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

  $conexion->close();
}
?>