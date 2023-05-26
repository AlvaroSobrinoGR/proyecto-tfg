<?php
require_once 'envio_de_correos.php'; 
require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

if(isset($_POST['email']) && isset($_POST['asunto']) && isset($_POST['consulta']) && isset($_POST['fecha'])){

  $email = $_POST['email'];
  $asunto = $_POST['asunto'];
  $consulta = $_POST['consulta'];
  $fecha = $_POST['fecha'];

  if(strlen(addslashes($asunto)) <= 255 && strlen(addslashes($consulta)) <= 255){
    if(strlen(addslashes($asunto)) >0 && strlen(addslashes($consulta)) > 0){
      
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
    
        $resultado = enviarCorreo($email, "$asunto. Id consulta: $ultimo_id" , "Codigo de la consulta: $ultimo_id <br>fecha: $fecha <br>estado: espera.<br> Le responderemos su consulta por este email.<br>consulta: $consulta");
      } catch (Throwable $t) {
        echo "Ha ocurrido un error: " . $t->getMessage();
      }
    
      if($resultado=="enviado"){
          echo "Se a creado la consulta. Tambien se le envio un email donde se le ira contactando.";
      }else{
          $consulta = "DELETE FROM consultas WHERE id_consulta = '$ultimo_id'";
          $conexion->query($consulta);
          echo "El email no se ha enviado. Algo ha fallado. Inténtelo de nuevo más tarde.";
      }
    } else {
      echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
    }
    }else{
      echo "Tanto el asunto como la consulta deben tener contenido.";
    }
    
  }else{
    echo "Tanto el asunto como el contenido de la consulta no pueden superar los 255 caracteres.";
  }
  
}else{
  echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
}
  
$conexion->close();
?>

