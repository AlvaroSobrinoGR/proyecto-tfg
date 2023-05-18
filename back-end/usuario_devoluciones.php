<?php

require_once 'envio_de_correos.php';
require_once 'pintar_factura_pedidos.php';

$conexion = new mysqli("localhost", "root", "", "tienda");

$email = $_POST["email"];
$id_compra = $_POST["id_pedido_devolver"];
$productos_cantidades = $_POST["productos_cantidades"];

$error = false;


$consulta = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0) {
    $id_usuario = $resultado->fetch_assoc()["id_usuario"];

    $consulta = "SELECT * FROM compra WHERE id_compra = '$id_compra' AND id_usuario = '$id_usuario'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {

        $productos_cantidades = explode(";", $productos_cantidades);
        $productos_cantidades = array_slice($productos_cantidades, 1, -1);

        if (count($productos_cantidades) > 0) {
            for ($i = 0; $i < count($productos_cantidades); $i++) {
                $temporal = explode("-", $productos_cantidades[$i]); //[0] producto [1] cantida
                $consulta = "SELECT * FROM compra_productos WHERE id_compra = '$id_compra' AND id_producto = '$temporal[0]'";
                $resultado = $conexion->query($consulta);

                if ($resultado->num_rows > 0) {
                    $fila = $resultado->fetch_assoc();
                    if ($fila["cantidad"] >= $temporal[1]) {
                        if ($fila["cantidad"] == $temporal[1]) {
                            $precioFinal = $fila["total_tras_descuento"];

                            $conexion->autocommit(false);

                            $consulta = "DELETE FROM compra_productos WHERE id_compra = '$id_compra' AND id_producto = '$temporal[0]'";



                            if ($conexion->query($consulta) == TRUE) {
                                //con el precio final restarlo a la factura y hacer el resto de precios recalcularlos.
                                $consulta = "SELECT * FROM compra WHERE id_compra = '$id_compra'";
                                $resultado = $conexion->query($consulta);
                                $fila = $resultado->fetch_assoc();

                                $precio_total = $fila["precio_total"] - $precioFinal;
                                $total_tras_codigo;
                                if (strlen($fila["id_cupon"]) > 0) {
                                    $cupon = $fila["id_cupon"];
                                    $consulta2 = "SELECT * FROM codigo_descuento WHERE BINARY id_cupon = '$cupon'";
                                    $resultado2 = $conexion->query($consulta2);
                                    $porcentaje_descuento = $resultado2->fetch_assoc()["porcentaje"];
                                    $total_tras_codigo = $precio_total - ($precio_total * $porcentaje_descuento / 100);
                                } else {
                                    $total_tras_codigo = $precio_total;
                                }
                                $total_final_con_iva = $total_tras_codigo + ($total_tras_codigo * $fila["porcentaje_iva"] / 100);

                                $consulta = "UPDATE compra
                                        SET precio_total = '$precio_total', total_tras_codigo= '$total_tras_codigo', total_final_con_iva= '$total_final_con_iva'
                                        WHERE id_compra = '$id_compra'";
                                $resultado = $conexion->query($consulta);
                            } else {
                                $conexion->rollback();
                                echo "No se pudo hacer la devolucion: " . $nombre;
                                $error = true;
                                break;
                            }
                        } else {
                            //hacer lo mismo que antes, pero como no son la mis a cantidad, habra que modificar la cantidad, sus avlores y despues los de la factura
                            $temporal[1];
                            $precio_unidad = $fila["precio_unidad"];
                            $precio_total = $precio_unidad * $temporal[1];
                            $porcentaje_descuento = $fila["porcentaje_descuento"];
                            $total_tras_descuento = $precio_total - ($precio_total * $porcentaje_descuento / 100);

                            $precio_total_restar = $fila["total_tras_descuento"] - $total_tras_descuento;

                            $conexion->autocommit(false);

                            $consulta = "UPDATE compra_productos
                                        SET cantidad = '$temporal[1]', precio_total= '$precio_total', total_tras_descuento= '$total_tras_descuento'
                                        WHERE id_compra = '$id_compra' AND id_producto = '$temporal[0]'";


                            if ($conexion->query($consulta) == TRUE) {
                                //con el precio final restarlo a la factura y hacer el resto de precios recalcularlos.
                                $consulta = "SELECT * FROM compra WHERE id_compra = '$id_compra'";
                                $resultado = $conexion->query($consulta);
                                $fila = $resultado->fetch_assoc();

                                $precio_total = $fila["precio_total"] - $precio_total_restar;
                                $total_tras_codigo;
                                if (strlen($fila["id_cupon"]) > 0) {
                                    $cupon = $fila["id_cupon"];
                                    $consulta2 = "SELECT * FROM codigo_descuento WHERE BINARY id_cupon = '$cupon'";
                                    $resultado2 = $conexion->query($consulta2);
                                    $porcentaje_descuento = $resultado2->fetch_assoc()["porcentaje"];
                                    $total_tras_codigo = $precio_total - ($precio_total * $porcentaje_descuento / 100);
                                } else {
                                    $total_tras_codigo = $precio_total;
                                }
                                $total_final_con_iva = $total_tras_codigo + ($total_tras_codigo * $fila["porcentaje_iva"] / 100);

                                $consulta = "UPDATE compra
                                        SET precio_total = '$precio_total', total_tras_codigo= '$total_tras_codigo', total_final_con_iva= '$total_final_con_iva'
                                        WHERE id_compra = '$id_compra'";
                                $resultado = $conexion->query($consulta);
                            } else {
                                $conexion->rollback();
                                echo "No se pudo hacer la devolucion: " . $nombre;
                                $error = true;
                                break;
                            }
                        }
                    } else {
                        $consulta = "SELECT * FROM productos WHERE id_producto = '$temporal[0]'";
                        $resultado = $conexion->query($consulta);
                        $nombre = $resultado->fetch_assoc()["nombre"];
                        echo "Estas intentando devolver mas productos de los que tienes en el producto: " . $nombre;
                        $error = true;
                        break;
                    }
                } else {
                    $consulta = "SELECT * FROM productos WHERE id_producto = '$temporal[0]'";
                    $resultado = $conexion->query($consulta);
                    $nombre = $resultado->fetch_assoc()["nombre"];
                    echo "Este producto no se encuentra en la compra: " . $nombre;
                    $error = true;
                    break;
                }
            }

            $eliminadaFactura = false;

            $consulta = "SELECT * FROM compra_productos WHERE id_compra = '$id_compra'";
            $resultado = $conexion->query($consulta);
            if ($resultado->num_rows == 0) {
                $consulta = "DELETE FROM compra WHERE id_compra = '$id_compra'";
                if ($conexion->query($consulta) == FALSE) {
                    $conexion->rollback();
                    $error = true;
                    echo "No se pudo hacer la devolucion";
                }else{
                    $eliminadaFactura = true;
                }
            }

            $conexion->autocommit(true);

            if(!$error){
                echo "devoluciohn realizada ";
                try {
                    if($eliminadaFactura){
                        enviarCorreo($email, "Devolucion realizada, factura eliminada", "Debido a que la factura de la compra con id ".$id_compra." se ha quedado sin productos y han sido todos devueltos se ha liminado. En los proximos dias se le devovlera todo el deinero y se parasara a recoger los productos a devolver");
                    }else{
                        enviarCorreo($email, "Devolucion realizada, factura actualizada", "Su factura a sido actualziada, en los proximos dias se le devolvera el dinero de la devolucion y se pasara a recoger los productos a devolver.<br>".pintarFactureaPedidos($id_compra, "Compra"));
                    }
                    
                } catch (\Throwable $th) {
                    $conexion->rollback(); //devuelve la base de datos al estaod anterior a las operacions
                    echo "No se pudo hacer la devolucion"+$th->getMessage();
                }
            }

            
        } else {
            echo "No hay ningun producto a devolver";
        }
    } else {
        echo "Este usuario no tiene la compra sobre la que quiere actuar";
    }
} else {
    echo "El email no es correcto";
}

$conexion->close();
?>