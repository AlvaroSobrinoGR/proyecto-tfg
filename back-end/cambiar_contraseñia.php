<?php

if (isset($_POST["email"]) && isset($_POST["codigo"]) && isset($_POST["contrasenia"]) && isset($_POST["contraseniaConfirmar"])) {
    $email = $_POST["email"];
    $codigo = $_POST["codigo"];
    $contrasenia = $_POST["contrasenia"];
    $contraseniaConfirmar = $_POST["contraseniaConfirmar"];
    
    $conexion = new mysqli("localhost", "root", "", "tienda");

    if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/', $contrasenia) && $contrasenia === $contraseniaConfirmar) {
        $conexion->autocommit(false);
        $hashedContrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
        $consulta = "UPDATE usuarios SET contrasenia = '$hashedContrasenia', codigo = 0  WHERE email = '$email' AND codigo = '$codigo'";
        if($conexion->query($consulta)==TRUE){
            $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
            $respuesta = $conexion->query($consulta);
            $fila = $respuesta-> fetch_assoc();
            if(password_verify($contrasenia, $fila["contrasenia"])){
                echo "exito";
            }else{
                $conexion->rollback();
                echo "fallo";
            }
            
        }else{
            $conexion->rollback();
            echo "fallo";
        }
        $conexion->autocommit(true);
    } else {
        echo "Las contraseñas no cumplen los requisitos o no son iguales Debe tener al menos 6 caracteres, un número, un carácter alfabético y un signo especial (@$!%*#?&).";
    }

    $conexion->close();
} else {
    echo "Falta uno o más campos en el formulario.";
}
    

?>