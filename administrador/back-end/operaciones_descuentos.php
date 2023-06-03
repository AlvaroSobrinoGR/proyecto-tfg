<?php
require_once 'conexion_base_datos.php';
require_once 'envio_de_correos.php'; 

$conexion = conexionBaseDatos();


    
    $tipo = $_POST['tipo'];
    if($tipo=="añadir"){
        $idProducto = $_POST['id_producto'];
        $porcentaje = $_POST['porcentaje'];

        // Verificar si existe el producto en la tabla productos
        $consultaProducto = "SELECT * FROM productos WHERE id_producto = '$idProducto'";
        $resultadoProducto = $conexion->query($consultaProducto);

        if ($resultadoProducto->num_rows > 0) {
            $fila = $resultadoProducto->fetch_assoc();
            if($fila["activo"] == 1 && $fila["stock"] > 0){
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
            }else{
                echo "El producto esta inacivo o no tiene stock, no se le peude aplicar el descuento";
            }
            
        } else {
            echo "El producto no existe.";
        }
    }else if($tipo=="eliminar"){
        $id_descuento = $_POST["id_descuento"];

        // Verificar si existe el descuento en la tabla
        $consulta = "SELECT * FROM descuentos WHERE id_descuento = '$id_descuento'";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
        // Eliminar la fila del descuento
        $eliminar = "DELETE FROM descuentos WHERE id_descuento = '$id_descuento'";
        if ($conexion->query($eliminar) === TRUE) {
            echo "Se ha eliminado el descuento con ID: " . $id_descuento;
        } else {
            echo "Error al eliminar el descuento: " . $conexion->error;
        }
        } else {
        echo "No existe el descuento con ID: " . $id_descuento;
        }
    }else{
        $id_descuento = $_POST["id_descuento"];
        $consulta = "SELECT porcentaje, id_producto FROM descuentos WHERE id_descuento = $id_descuento";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
            // El descuento existe, obtener los datos asociados
            $fila = $resultado->fetch_assoc();
            $porcentaje = $fila["porcentaje"];
            $id_producto = $fila["id_producto"];

            // Verificar si el producto está activo y tiene stock
            $consulta = "SELECT nombre,descripcion, precio, activo, stock FROM productos WHERE id_producto = $id_producto";
            $resultado = $conexion->query($consulta);

            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
                $nombre = $fila["nombre"];
                $descripcion = $fila["descripcion"];
                $precio = $fila["precio"];
                $activo = $fila["activo"];
                $stock = $fila["stock"];

                    if ($activo == 1 && $stock > 0) {

                        $consulta = "SELECT email FROM usuarios WHERE novedades = 1";
                        $resultado = $conexion->query($consulta);

                        
            
                        if ($resultado->num_rows > 0) {
                            $asunto = "El producto ".$nombre." ha recibido un ".$porcentaje."% de descuento";
                            $mensaje = "<p>El producto ".$nombre." ha recibido un ".$porcentaje."% de descuento.<br><br><del>" . number_format($precio, 2, ",", ".") . "</del>&euro; -" . $porcentaje . "% &#8594; " . number_format(($precio-($precio*$porcentaje/100)), 2, ",", ".") . "&euro; <br><br>
                            Descripcion del producto: ".$descripcion."<br><br>Enlace: ";

                            if(strpos($conexion->host_info,"localhost") !== false){
                                $mensaje .= "http://localhost/proyecto%20tfg/front-end/paginas_productos/paginaProducto".$id_producto."/paginaProducto".$id_producto.".html?id_producto=".$id_producto."</p>";
                            }else{
                                $mensaje .= "http://simplyminimal.epizy.com/front-end/paginas_productos/paginaProducto".$id_producto."/paginaProducto".$id_producto.".html?id_producto=".$id_producto."</p>"; 
                            }

                            while ($fila = $resultado->fetch_assoc()) {

                                enviarCorreo($fila["email"], $asunto, $mensaje);
                            }
                            
                            echo "Se han enviado los emails";
                        } else {
                            echo "No hay usuarios que quieran recivir novedades.";
                        }
            
                    } else {
                        echo "El producto al que se le aplica el descuento está desactivado o no tiene stock.";
                    }
                } else {
                    echo "El producto no existe.";
                }
        } else {
                echo "El descuento no existe.";
        }
           
    }


$conexion->close();
