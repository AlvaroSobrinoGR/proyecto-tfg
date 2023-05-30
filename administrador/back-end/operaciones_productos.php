<?php
require_once 'conexion_base_datos.php';
require_once 'envio_de_correos.php'; 

$conexion = conexionBaseDatos();


    
    $tipo = $_POST['tipo'];
    if($tipo=="modificarStock"){
        $id_producto = $_POST['id_producto'];
        $stock = $_POST['stock'];
        if($stock=="Z"){
            $stock = 0;
        }
        
        // Verificar si el producto existe
        $consulta = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
        $resultado = $conexion->query($consulta);
        
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            // El producto existe
            if ($fila["stock"] == 0 && $fila["activo"] == 1 && $stock > 0) {
                $nombre_prodcuto = $fila["nombre"];

                $consulta = "UPDATE productos SET stock = '$stock' WHERE id_producto = '$id_producto'";
                if ($conexion->query($consulta) === TRUE) {
                    
                    $consulta  = "SELECT email FROM usuarios u INNER JOIN avissos_disponibilidad a ON u.id_usuario = a.id_usuario WHERE a.id_producto = '$id_producto'";
                    $resultado = $conexion->query($consulta );

                    if ($resultado->num_rows > 0) {
                        $asunto = "Vuelve a haber stock del producto ".$nombre_prodcuto;
                        $mensaje = "";
                        if(strpos($conexion->host_info,"localhost") !== false){
                            $mensaje = "<p>Ya puede comprar nuestro producto en la tienda: http://localhost/proyecto%20tfg/front-end/paginas_productos/paginaProducto".$id_producto."/paginaProducto".$id_producto.".html?id_producto=".$id_producto."</p>";
                        }else{
                            $mensaje = "<p>Ya puede comprar nuestro producto en la tienda: http://simplyminimal.epizy.com/front-end/paginas_productos/paginaProducto".$id_producto."/paginaProducto".$id_producto.".html?id_producto=".$id_producto."</p>"; 
                        }
                       
                        while ($fila = $resultado->fetch_assoc()) {
                            enviarCorreo($fila["email"], $asunto, $mensaje);
                        }
                        $consulta = "DELETE FROM avissos_disponibilidad WHERE id_producto = '$id_producto'";
                        $conexion->query($consulta);
                        echo "se actualizo el stock correctamente\n";
                        echo "se enviaron los emails de aviso a los usuarios\n";
                        echo "se elimino el prodcuto de avisos_disponibilidad\n";
                    } else {
                        echo "No hay usuarios interesados en el producto con stock igual a 0.";
                    }
                } else {
                    echo "Error al actualizar el stock: " . $conexion->error;
                }
            } else {
                // Actualizar el stock del producto
                $consulta = "UPDATE productos SET stock = $stock WHERE id_producto = $id_producto";
                if ($conexion->query($consulta) === TRUE) {
                    echo "Stock actualizado correctamente.";
                } else {
                    echo "Error al actualizar el stock: " . $conexion->error;
                }
            }
        } else {
            echo "El producto no existe.";
        }
        
    }else if($tipo=="modificarEstado"){
        $id_producto = $_POST['id_producto'];
        $activo = $_POST['activo'];
        if($activo=="Z"){
            $activo = 0;
        }

        // Verificar si el producto existe
        $consulta = "SELECT id_producto FROM productos WHERE id_producto = '$id_producto'";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
            // Actualizar el valor de activo del producto
            $consulta = "UPDATE productos SET activo = $activo WHERE id_producto =' $id_producto'";
            if ($conexion->query($consulta) === TRUE) {
                echo "El valor 'activo' del producto con ID $id_producto se ha actualizado correctamente.";
            } else {
                echo "Error al actualizar el valor 'activo': " . $conexion->error;
            }
        } else {
            echo "El producto no existe.";
        }

    }else{
        $id_producto = $_POST['id_producto'];

        // Verificar si el producto existe en la tabla "productos"
        $consulta = "SELECT id_producto,nombre, descripcion, stock, activo FROM productos WHERE id_producto = $id_producto";
        $resultado = $conexion->query($consulta);
        
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $nombre_producto = $fila["nombre"];
            $descripcion = $fila["descripcion"];
            $activo = $fila["activo"];
            $stock = $fila["stock"];
        
            // Verificar si el producto tiene stock y está activo
            if ($stock > 0 && $activo == 1) {
                // Obtener los emails de la tabla "usuarios" con la columna "novedades" en valor 1
                $consulta = "SELECT email FROM usuarios WHERE novedades = 1";
                $resultado = $conexion->query($consulta);
        
                if ($resultado->num_rows > 0) {
                    $asunto = "Nuevo prodcuto en nuestra tienda: ".$nombre_producto;
                        $mensaje = "";
                        if(strpos($conexion->host_info,"localhost") !== false){
                            $mensaje = "<p>Ya puede comprar nuestro nuevo producto en la tienda: http://localhost/proyecto%20tfg/front-end/paginas_productos/paginaProducto".$id_producto."/paginaProducto".$id_producto.".html?id_producto=".$id_producto."</p>";
                        }else{
                            $mensaje = "<p>Ya puede comprar nuestro nuevo producto en la tienda: http://simplyminimal.epizy.com/front-end/paginas_productos/paginaProducto".$id_producto."/paginaProducto".$id_producto.".html?id_producto=".$id_producto."</p>"; 
                        }
                       
                        while ($fila = $resultado->fetch_assoc()) {
                            enviarCorreo($fila["email"], $asunto, $mensaje);
                        }
                        echo "Se enviaron los emails";
                } else {
                    echo "No hay usuarios con novedades.";
                }
            } else {
                echo "El producto no tiene stock o está inactivo, no se pueden enviar emails.";
            }
        } else {
            echo "El producto no existe.";
        }

    }


$conexion->close();

?>