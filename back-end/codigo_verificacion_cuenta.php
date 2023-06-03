<?php
require_once 'conexion_base_datos.php';
    $email = $_POST["email"];
    $codigo = $_POST["codigo"];

    $conexion = conexionBaseDatos();
    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $respuesta = $conexion->query($consulta);

    if($respuesta->num_rows > 0){
        $fila = $respuesta-> fetch_assoc();

        if($fila["validada"] == 0){
            if($fila["codigo"] == $codigo){
                $consulta = "UPDATE usuarios SET validada = 1, codigo = 0  WHERE email = '$email' AND codigo = '$codigo'";
                if($conexion->query($consulta)==TRUE){
                    echo "Tu cuenta ya esta verificada, ya puedes iniciar sesion en la pagina";
                }else{
                    echo "Algo ha fallado en la varificacion de tu cuenta";
                }
            }else{
                echo "El codigo de validacion no es valido, intente registrase de nuevo";
            }
        }else{
            echo "La cuenta ya fue validada";
        }
        
    }else{
        echo "La cuenta no esta resgistrada para su validacion";
    }

 



    $conexion->close();
?>