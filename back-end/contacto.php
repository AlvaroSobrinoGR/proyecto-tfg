<?php
require_once 'envio_de_correos.php'; 

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
  try {
    $ultimo_id = mysqli_insert_id($conexion);

    $resultado = enviarCorreo($email, "$asunto" , "Codigo de la consulta: $ultimo_id fecha <br>$fecha <br>estado: espera.<br> Le responderemos su consulta por este meial.<br>consulta: $consulta");
  } catch (Throwable $t) {
    echo "Ha ocurrido un error: " . $t->getMessage();
  }

  if($resultado=="enviado"){
      echo "exito;$email";
  }else{
      $consulta = "DELETE FROM consultas WHERE id_consulta = '$ultimo_id'";
      $conexion->query($consulta);
      echo "el email no se ha enviado";
  }
} else {
  echo "Error al crear la consulta: ";
}
  
$conexion->close();
?>

