<?php
    $email = $_POST["email"];
    $codigo = $_POST["codigo"];
    $contrasenia = $_POST["contrasenia"];

    $conexion = new mysqli("localhost", "root", "", "tienda");

    $consulta = "UPDATE usuarios SET contrasenia = '$contrasenia', codigo = 0  WHERE email = '$email' AND codigo = '$codigo'";
    if($conexion->query($consulta)==TRUE){
        $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
        $respuesta = $conexion->query($consulta);
        $fila = $respuesta-> fetch_assoc();
        if($fila["contrasenia"]==$contrasenia ){
            echo "exito";
        }else{
            echo "fallo";
        }
        
    }else{
        echo "fallo";
    }

    $conexion->close();
?>