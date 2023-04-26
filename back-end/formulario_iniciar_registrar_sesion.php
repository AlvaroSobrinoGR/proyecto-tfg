<?php


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
       
        $consulta = "INSERT INTO usuarios (email, contrasenia) VALUES ('$email', '$contrasenia')";
        if ($conexion->query($consulta) == TRUE) {

            enviarEmail($_POST["email"]);

            echo "Cuenta creada exitosamente;".$_POST["email"];

        } else {
            echo "Error al crear la cuenta: " . $conexion->error;
        }
    }
}

function enviarEmail($email){
    $to = 'estudiosalvaroestudios@gmail.com';
    $subject = 'Asunto del correo electrónico';
    $message = 'Este es el cuerpo del correo electrónico';
    $headers = 'From: paginatiendapruebas@gmail.com';

    if(mail($to, $subject, $message, $headers)){
        echo "correcto";
    }else{
        echo mail($to, $subject, $message, $headers);
    };
}

$conexion->close();
?>