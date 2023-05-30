<?php
require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();


    
    $tipo = $_POST['tipo'];
    if($tipo=="cargoConsulta"){
        $id_empleado = $_POST['id_empleado'];
        $id_consulta = $_POST['id_consulta'];

        $consulta = "SELECT * FROM empleados WHERE id_empleado = '$id_empleado'";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows == 0) {
            echo "El id_empleado no es correcto";
        } else {
            // Comprobar si el id_consulta es correcto
            $consulta = "SELECT * FROM consultas WHERE id_consulta = '$id_consulta'";
            $resultado = $conexion->query($consulta);

            if ($resultado->num_rows == 0) {
                echo "El id_consulta no es correcto";
            } else {
                // Comprobar si el id_consulta ya tiene un valor en id_empleado
                $consulta = "SELECT * FROM consultas WHERE id_consulta = '$id_consulta' AND id_empleado IS NOT NULL";
                $resultado = $conexion->query($consulta);

                if ($resultado->num_rows > 0) {
                    echo "El id_consulta ya tiene un valor en id_empleado";
                } else {
                    // Actualizar la tabla consultas con el nuevo valor de id_empleado y estado "trabajando"
                    $consulta = "UPDATE consultas SET id_empleado = '$id_empleado', estado = 'trabajando' WHERE id_consulta = '$id_consulta'";
                    $conexion->query($consulta);

                    echo "Se actualizó correctamente la tabla consultas";
                }
            }
        }


    }else if($tipo=="modifiaConsulta"){
        $id_empleado = $_POST['id_empleado'];
        $id_consulta = $_POST['id_consulta'];
        $estado = $_POST['estado'];

        $consulta = "SELECT * FROM empleados WHERE id_empleado = $id_empleado";
        $resultado = $conexion->query($consulta);
        
        if ($resultado->num_rows == 0) {
            echo "El id_empleado no es correcto";
        } else {
            // Comprobar si el id_consulta es correcto
            $consulta = "SELECT * FROM consultas WHERE id_consulta = $id_consulta";
            $resultado = $conexion->query($consulta);
        
            if ($resultado->num_rows == 0) {
                echo "El id_consulta no es correcto";
            } else {
                // Comprobar si el id_empleado de la consulta coincide con el id_empleado proporcionado
                $consulta = "SELECT * FROM consultas WHERE id_consulta = $id_consulta AND id_empleado = $id_empleado";
                $resultado = $conexion->query($consulta);
        
                if ($resultado->num_rows == 0) {
                    echo "La consulta no pertenece a este empleado";
                } else {
                    // Actualizar el estado de la consulta
                    $consulta = "UPDATE consultas SET estado = '$estado' WHERE id_consulta = $id_consulta";
                    $conexion->query($consulta);
        
                    echo "Se actualizó correctamente el estado de la consulta";
                }
            }
        }
    }
// Cerrar la conexión con la base de datos
$conexion->close();
?>