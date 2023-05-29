<?php
require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

if (isset($_POST['id_producto']) && isset($_POST['porcentaje']) && isset($_POST['tipo'])) {
    $idProducto = $_POST['id_producto'];
    $porcentaje = $_POST['porcentaje'];
    $tipo = $_POST['tipo'];
    if($tipo=="añadir"){

        // Verificar si existe el producto en la tabla productos
        $consultaProducto = "SELECT * FROM productos WHERE id_producto = '$idProducto'";
        $resultadoProducto = $conexion->query($consultaProducto);

        if ($resultadoProducto->num_rows > 0) {
            // Verificar si ya existe un descuento para el producto en la tabla descuentos
            $consultaDescuento = "SELECT * FROM descuentos WHERE id_producto = '$idProducto'";
            $resultadoDescuento = $conexion->query($consultaDescuento);

            if ($resultadoDescuento->num_rows > 0) {
                echo "El producto ya tiene un descuento.";
            } else {
                // Insertar el descuento en la tabla descuentos
                $insercionDescuento = "INSERT INTO descuentos (porcentaje, id_producto) VALUES ('$porcentaje', '$idProducto')";
                if ($conexion->query($insercionDescuento) === TRUE) {
                    echo "El descuento se ha agregado correctamente.";
                } else {
                    echo "Error al agregar el descuento: " . $conexion->error;
                }
            }
        } else {
            echo "El producto no existe.";
        }
    }

} else {
    echo "Datos de entrada incorrectos.";
}

$conexion->close();

?>