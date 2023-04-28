<?php

require_once 'envio_de_correos.php'; // es el documento donde esta el envio de emails

$conexion = new mysqli("localhost", "root", "", "tienda");


$tipo = $_POST["tipo"];
$email = $_POST["email"]; 
$contrasenia = $_POST["contrasenia"];
if($tipo=="creacion"){
    $novedades = $_POST["novedades"];
}


if ($tipo == "inicio") {
    
    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($consulta);
    $fila = $resultado->fetch_assoc();

    if ($resultado->num_rows > 0 && $fila["validada"] == 1) {
        
        
        if ($contrasenia === $fila["contrasenia"]) {

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

        $fila = $resultado-> fetch_assoc();

        if ($fila["validada"] == 1) {

            echo "Ya existe una cuenta con este email";
    
        }else{
            $id_usuario = $fila["id_usuario"];

            $consulta = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
            $conexion->query($consulta);
            
            crear($conexion, $email, $contrasenia, $novedades);
        }
        

    } else {

        crear($conexion, $email, $contrasenia, $novedades);
        
    }
}

function crear($conexion, $email, $contrasenia, $novedades){
    $codgioConfirmacion = uniqid();
       
    $consulta = "INSERT INTO usuarios (email, contrasenia, validada, codigo, novedades) VALUES ('$email', '$contrasenia', '0', '$codgioConfirmacion', '$novedades')";
    if ($conexion->query($consulta) == TRUE) {

        $ultimo_id = mysqli_insert_id($conexion);

        $resultado = enviarCorreo($email, "Confirmar creacion de cuenta", "esta es la confirmacion de la creacion de la cuenta http://localhost/proyecto%20tfg/front-end/inicio.html?email=$email&hash=$codgioConfirmacion");

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

$conexion->close();
?>