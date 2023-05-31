<?php
require_once 'envio_de_correos.php';
require_once 'conexion_base_datos.php';
// Recoger datos del formulario

if(isset($_POST['tipo']) && isset($_POST['email'])){
  $tipo = $_POST['tipo'];
    
  $conexion = conexionBaseDatos();

  if($tipo === "cargar"){ //cargar los datos
    $email = $_POST['email'];

    $consulta = "SELECT * FROM usuarios  WHERE email = '$email'";
    
    if ($conexion->query($consulta) == TRUE) {
      $resultado = $conexion->query($consulta);

      $json = "[";

      $fila = $resultado-> fetch_assoc();
      $json .= "{";
      
      $id_datos = $fila["id_datos"];
      $json .= "\"novedades\" : \"".$fila["novedades"]."\",";//1 hay stock 0 no hay stock

      if(strlen($id_datos) > 0){
        $consulta = "SELECT * FROM datos_usuario  WHERE id_datos = '$id_datos'";
        if ($conexion->query($consulta) == TRUE) {
          $resultado = $conexion->query($consulta);
          $fila = $resultado-> fetch_assoc();
          $json .= "\"nombre\" : \"".$fila["nombre_apellido"]."\",";
          $json .= "\"direccion\" : \"".$fila["direccion"]."\",";
          $json .= "\"telefono\" : \"".($fila["telefono"]!=0?$fila["telefono"]:"")."\"";
        }
      }else{
        $json .= "\"nombre\" : \"\",";
        $json .= "\"direccion\" : \"\",";
        $json .= "\"telefono\" : \"\"";
      }

      $json .= "}";

      echo $json."]";

    }else{
      echo "No que consiguio insertar los datos en las tablas: " . $conexion->error;
    }

  }else if ($tipo === "configuracion") { //cambiar los datos PATRONES
    if (isset($_POST['nombre']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['novedades'])){

        $email = $_POST['email'];
        $nombre = trim($_POST['nombre']);
        $direccion = $_POST['direccion'];
        $telefono = trim($_POST['telefono']);
        $novedades = $_POST['novedades'];

        $exito = true;

        if(!preg_match('/^[A-ZÁÉÍÓÚÑ][a-zA-ZÁÉÍÓÚÑ]*(?:\s+[A-ZÁÉÍÓÚÑ][a-zA-ZÁÉÍÓÚÑ]*){1,}$/', $nombre) && strlen($nombre)>0){
          $exito = false;
          echo "Nombre: Debes introducir almenos un nombre y un apellido como minimo, y deben empezar por mayuscula";
        }
        if(!preg_match('/^\d{9}$/', $telefono) && strlen($telefono)>0){
          $exito = false;
          echo "Telefono: El telefono solo puede tener numeros y deben ser 9";
        }
        if($exito){
              
            //primero ver los datos en datos_usuario
            $id_datos;
            $consulta = "SELECT id_datos FROM datos_usuario WHERE nombre_apellido='$nombre' AND direccion='$direccion' AND telefono='$telefono'";
            $resultado = $conexion->query($consulta);
        
            if ($resultado->num_rows > 0) {
                // Los datos ya están registrados, obtener el ID
                $row = $resultado->fetch_assoc();
                $id_datos = $row['id_datos'];
            } else {
                // Los datos no están registrados, insertar nueva fila
                $consulta = "INSERT INTO datos_usuario (nombre_apellido, direccion, telefono) VALUES ('$nombre', '$direccion', '$telefono')";
                if ($conexion->query($consulta) === TRUE) {
                  $id_datos = mysqli_insert_id($conexion);
                } else {
                    echo "Error: " . $consulta . "<br>" . $conexion->error;
                }
            }
            //insertamos el nuevo id de datos_usuario al usario
            if($id_datos != "ya existe"){
              $consulta = "UPDATE usuarios SET id_datos = '$id_datos' WHERE email = '$email';";
        
              if ($conexion->query($consulta) == TRUE) {
                echo "los datos se han actualizado";
              }else{
                echo "los datos no se han actualizado, ha surgido un error";
              }  
            }
        
        
            $consulta = "UPDATE usuarios SET id_datos='$id_datos', novedades = '$novedades' WHERE email = '$email';";
        
            if ($conexion->query($consulta) == TRUE) {
              echo "los datos se han actualizado";
            }else{
              echo "los datos no se han actualizado, ha surgido un error";
            }
          }
      }else{
        echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
      }
    
  

  } else if($tipo === "configuracionCarrito"){ //PATRONES

    if (isset($_POST['nombre']) && isset($_POST['direccion']) && isset($_POST['telefono'])){
        
      $email = $_POST['email'];
      $nombre = trim($_POST['nombre']);
      $direccion = $_POST['direccion'];
      $telefono = trim($_POST['telefono']);

      if(strlen($direccion)>0 && preg_match('/^[A-ZÁÉÍÓÚÑ][a-zA-ZÁÉÍÓÚÑ]*(?:\s+[A-ZÁÉÍÓÚÑ][a-zA-ZÁÉÍÓÚÑ]*){1,}$/', $nombre) && preg_match('/^\d{9}$/', $telefono)){

        //primero ver los datos en datos_usuario
        $id_datos = "ya existe";
        $consulta = "SELECT id_datos FROM datos_usuario WHERE nombre_apellido='$nombre' AND direccion='$direccion' AND telefono='$telefono'";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
            // Los datos ya están registrados, obtener el ID
            $id_datos = "ya existe";
            $row = $resultado->fetch_assoc();
            $id_datos = $row['id_datos'];
        } else {
            // Los datos no están registrados, insertar nueva fila
            $consulta = "INSERT INTO datos_usuario (nombre_apellido, direccion, telefono) VALUES ('$nombre', '$direccion', '$telefono')";
            if ($conexion->query($consulta) === TRUE) {
              $id_datos = mysqli_insert_id($conexion);
            } else {
                echo "Error: " . $consulta . "<br>" . $conexion->error;
            }
        }
        //insertamos el nuevo id de datos_usuario al usario
        if($id_datos != "ya existe"){
          $consulta = "UPDATE usuarios SET id_datos = '$id_datos' WHERE email = '$email';";

          if ($conexion->query($consulta) == TRUE) {
            echo "los datos se han actualizado";
          }else{
            echo "los datos no se han actualizado, ha surgido un error";
          }  
        }else{
          echo "los datos ya existian";
        }

        $consulta = "UPDATE usuarios SET id_datos='$id_datos' WHERE email = '$email'";

      }else{
        echo "Tiene que estas correcto tanto el nombre, como la direccion y el telefono.\n Nombre: Debes introducir almenos un nombre y un apellido como minimo, y deben empezar por mayuscula\n Direccion: escribir alguina direccion\nTelefono: El telefono solo puede tener numeros y deben ser 9";
      
      }
      }else{
        echo "Falta algun dato del usuario para poder hacer la compra, vuelve a probar mas tarde";
        }

    
  }else {  //comtrasenia
    // Recoger datos del formulario para cambiar contraseña
    $email = $_POST["email"];

    $codgioConfirmacion = uniqid();

    $consulta = "UPDATE usuarios SET codigo = '$codgioConfirmacion'  WHERE email = '$email'";

    if ($conexion->query($consulta) == TRUE) {

      if(strpos($conexion->host_info,"localhost") !== false){
        $resultado = enviarCorreo($email, "Cambiar su clave de acceso", "En este enlace podras cambiar tu contraseña http://localhost/proyecto%20tfg/front-end/cambiar_contraseña.html?email=$email&hash=$codgioConfirmacion");
      }else{
        $resultado = enviarCorreo($email, "Cambiar su clave de acceso", "En este enlace podras cambiar tu contraseña http://simplyminimal.epizy.com/front-end/cambiar_contraseña.html?email=$email&hash=$codgioConfirmacion");
      }
        
        if($resultado=="enviado"){
            echo "Se ha enviado un email para cambiar la contraseña";
        }else{
            $consulta = "UPDATE usuarios SET codigo = 0  WHERE email = '$email'";
            $conexion->query($consulta);
            echo "el email no se ha enviado";
        }

    } else {
        echo "No que consiguio insertar los datos en las tablas: " . $conexion->error;
    }

    $conexion->close();
  }
}else{
  echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
}
?>