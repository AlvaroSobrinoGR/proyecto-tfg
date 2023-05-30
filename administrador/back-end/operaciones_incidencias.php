<?php
require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();


    
    $tipo = $_POST['tipo'];
    if($tipo=="cargoIncidencia"){
        $id_empleado = $_POST['id_empleado'];
        $id_incidencia = $_POST['id_incidencia'];

        $consulta = "SELECT * FROM empleados WHERE id_empleado = '$id_empleado'";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows == 0) {
            echo "El id_empleado no es correcto";
        } else {
            // Comprobar si el id_incidencia es correcto
            $consulta = "SELECT * FROM incidencias WHERE id_incidencia = '$id_incidencia'";
            $resultado = $conexion->query($consulta);

            if ($resultado->num_rows == 0) {
                echo "El id_incidencia no es correcto";
            } else {
                // Comprobar si el id_incidencia ya tiene un valor en id_empleado
                $consulta = "SELECT * FROM incidencias WHERE id_incidencia = '$id_incidencia' AND id_empleado IS NOT NULL";
                $resultado = $conexion->query($consulta);

                if ($resultado->num_rows > 0) {
                    echo "El id_incidencia ya tiene un valor en id_empleado";
                } else {
                    // Actualizar la tabla incidencias con el nuevo valor de id_empleado y estado "trabajando"
                    $consulta = "UPDATE incidencias SET id_empleado = '$id_empleado', estado = 'trabajando' WHERE id_incidencia = '$id_incidencia'";
                    $conexion->query($consulta);

                    echo "Se actualizó correctamente la tabla incidencias";
                }
            }
        }


    }else if($tipo=="modifiaIncidencia"){
        $id_empleado = $_POST['id_empleado'];
        $id_incidencia = $_POST['id_incidencia'];
        $estado = $_POST['estado'];

        $consulta = "SELECT * FROM empleados WHERE id_empleado = $id_empleado";
        $resultado = $conexion->query($consulta);
        
        if ($resultado->num_rows == 0) {
            echo "El id_empleado no es correcto";
        } else {
            // Comprobar si el id_incidencia es correcto
            $consulta = "SELECT * FROM incidencias WHERE id_incidencia = $id_incidencia";
            $resultado = $conexion->query($consulta);
        
            if ($resultado->num_rows == 0) {
                echo "El id_incidencia no es correcto";
            } else {
                // Comprobar si el id_empleado de la incidencia coincide con el id_empleado proporcionado
                $consulta = "SELECT * FROM incidencias WHERE id_incidencia = $id_incidencia AND id_empleado = $id_empleado";
                $resultado = $conexion->query($consulta);
        
                if ($resultado->num_rows == 0) {
                    echo "La incidencia no pertenece a este empleado";
                } else {
                    // Actualizar el estado de la incidencia
                    $consulta = "UPDATE incidencias SET estado = '$estado' WHERE id_incidencia = $id_incidencia";
                    $conexion->query($consulta);
        
                    echo "Se actualizó correctamente el estado de la incidencia";
                }
            }
        }
    }
// Cerrar la conexión con la base de datos
$conexion->close();
?>