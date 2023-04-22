<?php
    $conexion = new mysqli("localhost", "root", "", "tienda");

    $email = $_POST["email"];
    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {
        echo "La cuenta si existe";
    } else {
        echo "La cuenta no existe";
    }
    
?>