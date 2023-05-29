<?php
require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();


    
    $tipo = $_POST['tipo'];
    if($tipo=="añadir"){
        $codigo = $_POST['codigo'];
        $porcentaje = $_POST['porcentaje'];
        $estado = $_POST['estado'];
        if($estado=="Z"){
            $estado = 0;
        }
        
        $consultaDescuento = "SELECT * FROM codigo_descuento WHERE id_cupon = '$codigo'";
        $resultadoDescuento = $conexion->query($consultaDescuento);

            if ($resultadoDescuento->num_rows > 0) {
                echo "El codigo descuento ya existe";
            } else {
                // Insertar el descuento en la tabla descuentos
                $insercionDescuento = "INSERT INTO codigo_descuento (id_cupon, porcentaje, estado) VALUES ('$codigo','$porcentaje', '$estado')";
                if ($conexion->query($insercionDescuento) === TRUE) {
                    echo "El codigo se ha agregado correctamente.";
                } else {
                    echo "Error al agregar el descuento: " . $conexion->error;
                }
            }

    }else if($tipo=="eliminar"){
        $codigo = $_POST["codigo"];

        // Verificar si existe el descuento en la tabla
        $consulta = "SELECT * FROM codigo_descuento WHERE id_cupon = '$codigo'";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
        // Eliminar la fila del descuento
            $eliminar = "DELETE FROM codigo_descuento WHERE id_cupon = '$codigo'";
            if ($conexion->query($eliminar) === TRUE) {
                echo "Se ha eliminado el descuento con ID: " . $codigo;
            } else {
                echo "Error al eliminar el descuento: " . $conexion->error;
            }
        } else {
        echo "No existe el descuento con codigo: " . $codigo;
        }
    }else{
        
        $codigo = $_POST["codigo"];
        $estado = $_POST["estado"];
        if($estado=="Z"){
            $estado = 0;
        }


        // Verificar si existe el código en la tabla
        $consulta = "SELECT * FROM codigo_descuento WHERE id_cupon= '$codigo'";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
        // Actualizar el estado del código
            $actualizar = "UPDATE codigo_descuento SET estado = '$estado' WHERE id_cupon = '$codigo'";
            if ($conexion->query($actualizar) === TRUE) {
                echo "Se ha actualizado el estado del código : " . $codigo;
            } else {
                echo "Error al actualizar el estado del código: " . $conexion->error;
            }
        } else {
            echo "No existe el código: " . $codigo;
        }
    }


$conexion->close();

?>