<?php
require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();
$email = $_POST['email_empleado'];


// Realizar la consulta para obtener el id_empleado basado en el email
$cosulta = "SELECT id_empleado FROM empleados WHERE email = '$email'";
$resultado = $conexion->query($cosulta);

if ($resultado->num_rows > 0) {
    // Imprimir el id_empleado
    $fila = $resultado->fetch_assoc();
    echo $fila['id_empleado'];
} else {
    echo "No se encontró ningún empleado con el email '$email'";
}

// Cerrar la conexión con la base de datos
$conexion->close();
?>