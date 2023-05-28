<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

// Datos del nuevo empleado
$nombre_apellido = "Pepe Soleres";//empleado nombre
$email = "Pepe.Soleres@SimplyMinimal.com"; //empleado email
$contrasenia = "pepe2$"; //em pleado contraseña

// Verificar si hay errores de conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Verificar si ya existe un empleado con el mismo nombre o correo electrónico
$consulta = "SELECT * FROM empleados WHERE nombre_apellidos = '$nombre_apellido' OR email = '$email'";
$resultado = $conexion->query($consulta);
if ($resultado->num_rows > 0) {
    // Ya existe un empleado con ese nombre o correo electrónico
    echo "Ya existe un empleado registrado con el mismo nombre o correo electrónico.";
} else {
    // No hay duplicados, insertar el nuevo empleado en la tabla
    $hashedContrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);

    $consulta = "INSERT INTO empleados (nombre_apellidos, email, contraseña) VALUES ('$nombre_apellido', '$email', '$hashedContrasenia')";
    if ($conexion->query($consulta) === TRUE) {
        echo "Nuevo empleado añadido correctamente.";
    } else {
        echo "Error al añadir el empleado: " . $conexion->error;
    }
}

// Cerrar la conexión a la base de datos
$conexion->close();

?>