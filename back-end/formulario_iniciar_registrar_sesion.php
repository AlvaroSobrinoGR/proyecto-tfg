<?php

require_once 'envio_de_correos.php'; // es el documento donde esta el envio de emails

$conexion = new mysqli("localhost", "root", "", "tienda");


$tipo = $_POST["tipo"];
$email = $_POST["email"]; 
$contrasenia = $_POST["contrasenia"]; 


if ($tipo == "inicio") {
    
    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {
        
        $row = $resultado->fetch_assoc();
        if ($contrasenia === $row["contrasenia"]) {

            echo "La cuenta es correcta;".$_POST["email"];
        } else {
        
            echo "La contraseña está mal";
        }
    } else {
    
        echo "La cuenta no existe";
    }

} elseif ($tipo == "creacion") {
   
    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {
       
        echo "Ya existe una cuenta con este email";
    } else {

        $codgioConfirmacion = uniqid();
       
        $consulta = "INSERT INTO usuarios (email, contrasenia, validada, codigo) VALUES ('$email', '$contrasenia', '0', '$codgioConfirmacion')";
        if ($conexion->query($consulta) == TRUE) {

            $ultimo_id = mysqli_insert_id($conexion);

            $resultado = enviarCorreo($email, "Confirmar creacion de cuenta", "esta es la confirmacion de la creacion de la cuenta '$codgioConfirmacion'");

            if($resultado=="enviado"){
                echo "exito;$email";
            }else{
                $consulta = "DELETE FROM usuarios WHERE id_usuario = '$ultimo_id'";
                $conexion->query($consulta);
                echo "el email no se ha enviado";
            }

        } else {
            echo "No que consiguio insertar los datos en las tablas: " . $conexion->error;
        }
    }
}


$conexion->close();
?>