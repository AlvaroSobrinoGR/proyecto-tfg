<?php
require_once 'conexion_base_datos.php';
    $email = $_POST["email"];
    $codigo = $_POST["codigo"];

    $conexion = conexionBaseDatos();

    $consulta = "UPDATE usuarios SET validada = 1, codigo = 0  WHERE email = '$email' AND codigo = '$codigo'";
    if($conexion->query($consulta)==TRUE){
        echo "Tu cuenta ya esta verificada, ya puedes iniciar sesion en la pagina";
    }else{
        echo "Algo ha fallado en la varificacion de tu cuenta";
    }



    $conexion->close();
?>