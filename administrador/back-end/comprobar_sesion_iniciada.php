<?php
require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

    $email = $_POST["email"];
    $consulta = "SELECT * FROM empleados WHERE email = '$email'";
    $resultado = $conexion->query($consulta);
    
    if ($resultado->num_rows > 0) {
        echo "La cuenta si existe";
    } else {
        echo "La cuenta no existetete";
    }
    
?>