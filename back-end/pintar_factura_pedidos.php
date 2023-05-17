<?php


if(isset($_POST["id_pedido"])){
    $pedido = $_POST["id_pedido"];
    pintarFactureaPedidos($pedido, "usuario");
}

function pintarFactureaPedidos($pedido, $tipo){
    $conexion = new mysqli("localhost", "root", "", "tienda");

    $tabla = "";

    $consulta = "SELECT *  FROM compra WHERE id_compra = '$pedido'";
    $resultado = $conexion->query($consulta);

    if($resultado->num_rows > 0) {
        $filaPedido = $resultado-> fetch_assoc();

        $datos = $filaPedido["id_datos_comprador"];
        $consultaDatos = "SELECT *  FROM datos_usuario WHERE id_datos = '$datos'";
        $resultadoDatos = $conexion->query($consultaDatos);

        if($resultadoDatos->num_rows > 0) {
            $filaDatos = $resultadoDatos-> fetch_assoc();


            $tabla = '
            <style>
            .productos {
                text-align: center;
            }
            
            .productos td {
                text-align: center;
            }
            </style>

            <table>
            <tr>
                <td>Id compra: '.$filaPedido["id_compra"].'</td>
                <td colspan="4">Fecha compra: '.$filaPedido["tiempo_local_compra"].'</td>
            </tr>
            <tr>
                <th colspan="2">Direccion de envio</th>
                <th>Datos del pagador</th>
                <th colspan="2">Resumen compra</th>
            </tr>
            <tr>
                <td colspan="2">'.$filaDatos["nombre_apellido"].'</td>
                <td>'.$filaPedido["nombre_apellido_pagador"].'</td>
                <td colspan="2">Precio total: '.$filaPedido["precio_total"].'</td>
            </tr>
            <tr>
                <td colspan="2">'.$filaDatos["telefono"].'</td>
                <td>'.$filaPedido["email_pagador"].'</td>';
            
            $id_cupon = $filaPedido["id_cupon"];
            $consultaCupon = "SELECT *  FROM codigo_descuento WHERE id_cupon = '$id_cupon'";
            $resultadoCupon = $conexion->query($consultaCupon);

            if($resultadoCupon->num_rows > 0){
                $filaCupon = $resultadoCupon-> fetch_assoc();
                $tabla .= '<td colspan="2">Codigo Descuento: '.$filaPedido["id_cupon"].'->'.$filaCupon["porcentaje"].'%</td>';
            }else{
                $tabla .= '<td colspan="2">Codigo Descuento: </td>';
            }

            $tabla .= '</tr>
            <tr>
                <td>'.$filaDatos["direccion"].'</td>
                <td colspan="2"></td>
                <td>Tras codigo deceunto: '.$filaPedido["total_tras_codigo"].'</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2">Porcentaje de iva: '.$filaPedido["porcentaje_iva"].'%</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2">Total final: '.$filaPedido["total_final_con_iva"].'</td>
            </tr>
            <tr>
                <td colspan="5" class="productos">Prodcutos</td>
            </tr>';


            $consultaProductos = "SELECT *  FROM compra_productos WHERE id_compra = '$pedido'";
            $resultadoProductos = $conexion->query($consultaProductos);
        
            if( $resultadoProductos->num_rows > 0) {
                
                if($tipo=="Compra"){
                    $tabla .= '<tr class="productos">
                    <td colspan="2">Nombre</td>
                    <td>Catidad</td>
                    <td>Precio Individual</td>
                    <td>Precio Final Total</td>
                    </tr>';
                }else{
                    $tabla .= '<tr class="productos">
                    <td></td>
                    <td>Nombre</td>
                    <td>Catidad</td>
                    <td>Precio Individual</td>
                    <td>Precio Final Total</td>
                    </tr>';
                
                }
            while ($filaProductos = $resultadoProductos-> fetch_assoc()){

                if($tipo=="Compra"){
                    $tabla .= '<tr class="productos">';

                    $id_productoConcreto = $filaProductos["id_producto"];
                    $consultaProductoConcreto = "SELECT *  FROM productos WHERE id_producto = '$id_productoConcreto'";
                    $resultadoProductoConcreto = $conexion->query($consultaProductoConcreto);
                    
                    if($resultadoProductoConcreto->num_rows > 0) {
                        $filaPC = $resultadoProductoConcreto-> fetch_assoc();

                        $tabla .= '<td colspan="2">'.$filaPC["nombre"].'</td>';
            
                    }else{
                        $tabla .= '<td colspan="2">[nombre]</td>';
                    }
                }else{
                    $tabla .= '<tr class="productos">
                    <td><img src=img_productos/'.$filaProductos["id_producto"].'.jpg></td>';

                    $id_productoConcreto = $filaProductos["id_producto"];
                    $consultaProductoConcreto = "SELECT *  FROM productos WHERE id_producto = '$id_productoConcreto'";
                    $resultadoProductoConcreto = $conexion->query($consultaProductoConcreto);
                    
                    if($resultadoProductoConcreto->num_rows > 0) {
                        $filaPC = $resultadoProductoConcreto-> fetch_assoc();

                        $tabla .= '<td>'.$filaPC["nombre"].'</td>';
            
                    }else{
                        $tabla .= '<td>[nombre]</td>';
                    }
                }
                

                $tabla .= '<td>'.$filaProductos["cantidad"].'</td>';

                    if($filaProductos["porcentaje_descuento"]>0){
                        $tabla .='<td><del>'.$filaProductos["precio_unidad"].'</del>'.$filaProductos["porcentaje_descuento"].'%-->'.number_format((double)$filaProductos["precio_unidad"]-((double)$filaProductos["precio_unidad"]*(double)$filaProductos["porcentaje_descuento"]/100),2).'</td>';
                    }else{
                        $tabla .='<td>'.$filaProductos["precio_unidad"].'</td>';
                    }
                    
                
                    $tabla .='<td>'.$filaProductos["total_tras_descuento"].'</td>
                </tr>';
            }
            $tabla .='</table>';

            if(isset($_POST["id_pedido"])){
                
            echo $tabla;
            }else{
                return $tabla;
            }
            }
        }
        
    }
$conexion->close();
}

?>