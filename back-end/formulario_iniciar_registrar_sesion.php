<?php

require_once 'envio_de_correos.php'; // es el documento donde esta el envio de emails
require_once 'conexion_base_datos.php';



if (isset($_POST["tipo"]) && isset($_POST["email"]) && isset($_POST["contrasenia"])) {
    $tipo = $_POST["tipo"];
    $email = $_POST["email"];
    $contrasenia = $_POST["contrasenia"];
  
    // Verificar tipo "creacion"
    if ($tipo === "creacion") {
      if (isset($_POST["contraseniaConfirmacion"]) && isset($_POST["novedades"])) {
        $contraseniaConfirmacion = $_POST["contraseniaConfirmacion"];
        $novedades = $_POST["novedades"];
  
        // Verificar patrón de email
        if (preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
          // Verificar patrón de contraseñas y que sean iguales
          if (preg_match('/^(?=.*[A-Za-zÁÉÍÓÚÑáéíóúñ])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-zÁÉÍÓÚÑáéíóúñ\d@$!%*#?&]{6,}$/', $contrasenia) && $contrasenia === $contraseniaConfirmacion) {
            todoCorrecto("creacion");
          } else {
            echo "Las contraseñas no cumplen los requisitos o no son iguales Debe tener al menos 6 caracteres, un número, un carácter alfabético y un signo especial (@$!%*#?&).";
          }
        } else {
          echo "El correo electrónico no cumple el patrón requerido";
        }
      } else {
        echo "Faltan elementos necesarios (contraseniaConfirmacion, novedades)";
      }
    } else {
        todoCorrecto($tipo);
    }
  } else {
    echo "Faltan elementos necesarios (tipo, email, contraseñia)";
  }

function todoCorrecto($tipo){
    $email = $_POST["email"]; 
    $contrasenia = $_POST["contrasenia"];
    if($tipo=="creacion"){
        $novedades = $_POST["novedades"];
    }
    $conexion = conexionBaseDatos();
    if ($tipo == "inicio") {
    
        $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $conexion->query($consulta);
        $fila = $resultado->fetch_assoc();
    
        if ($resultado->num_rows > 0 && $fila["validada"] == 1) {
            
            if (password_verify($contrasenia, $fila["contrasenia"])) {
    
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
    
    $conexion->close();
}

function crear($conexion, $email, $contrasenia, $novedades){
    $codgioConfirmacion = uniqid();

    $hashedContrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
       
    $consulta = "INSERT INTO usuarios (email, contrasenia, validada, codigo, novedades) VALUES ('$email', '$hashedContrasenia', '0', '$codgioConfirmacion', '$novedades')";
    if ($conexion->query($consulta) == TRUE) {
        try {
            $ultimo_id = mysqli_insert_id($conexion);
            if(strpos($conexion->host_info,"localhost") !== false){
              $resultado = enviarCorreo($email, "Confirmar creacion de cuenta", "esta es la confirmacion de la creacion de la cuenta http://localhost/proyecto%20tfg/front-end/inicio.html?email=$email&hash=$codgioConfirmacion");
             }else{
              $resultado = enviarCorreo($email, "Confirmar creacion de cuenta", "esta es la confirmacion de la creacion de la cuenta http://simplyminimal.epizy.com/front-end/inicio.html?email=$email&hash=$codgioConfirmacion");
            }
            
          } catch (Throwable $t) {
            echo "Ha ocurrido un error: " . $t->getMessage();
          }

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

?>