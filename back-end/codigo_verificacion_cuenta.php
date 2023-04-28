<?php
    $email = $_POST["email"];
    $codigo = $_POST["codigo"];

    $conexion = new mysqli("localhost", "root", "", "tienda");

    $consulta = "UPDATE usuarios SET validada = 1, codigo = 0  WHERE email = '$email' AND codigo = '$codigo'";
    $resultado = $conexion->query($consulta);

    $conexion->close();
?>