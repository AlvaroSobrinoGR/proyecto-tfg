<?php


$conexion = new mysqli("localhost", "root", "", "tienda");

// Obtener datos del formulario
$tipo = $_POST["tipo"]; // Obtener el valor del campo "tipo" del formulario
$email = $_POST["email"]; // Obtener el valor del campo "email" del formulario
$contrasenia = $_POST["contrasenia"]; // Obtener el valor del campo "contrasenia" del formulario

// Comprobar el tipo de solicitud
if ($tipo == "inicio") {
    // Comprobar si la cuenta existe en la tabla "usuarios"
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        // La cuenta existe, verificar la contraseña
        $row = $result->fetch_assoc();
        if ($contrasenia === $row["contrasenia"]) {
            // Contraseña correcta
            echo "La cuenta es correcta";
        } else {
            // Contraseña incorrecta
            echo "La contraseña está mal";
        }
    } else {
        // La cuenta no existe
        echo "La cuenta no existe";
    }

} elseif ($tipo == "creacion") {
    // Comprobar si existe una cuenta con el mismo email en la tabla "usuarios"
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        // Existe una cuenta con el mismo email
        echo "Ya existe una cuenta con este email";
    } else {
        // Guardar el nuevo usuario en la tabla "usuarios"
        $sql = "INSERT INTO usuarios (email, contrasenia) VALUES ('$email', '$contrasenia')";
        if ($conexion->query($sql) == TRUE) {
            echo "Cuenta creada exitosamente";
        } else {
            echo "Error al crear la cuenta: " . $conexion->error;
        }
    }
}

// Cerrar la conexión a la base de datos
$conexion->close();
