<?php

require_once 'conexion_base_datos.php';

if(isset($_POST["id_pedido"])){
    $pedido = $_POST["id_pedido"];
    pintarFactureaPedidos($pedido, "usuario");
}else{
    echo "Algo ha fallado en la factura. Inténtelo de nuevo más tarde.";
}

function pintarFactureaPedidos($pedido, $tipo){
    $conexion = conexionBaseDatos();

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
            .facutra_centrado {
                text-align: center;
            }
            
            .facutra_centrado td, .facutra_centrado th{
                text-align: center;
            }
            </style>

            <table>
            <tr>
                <td><b>Id compra: </b>'.$filaPedido["id_compra"].'</td>
                <td colspan="4"><b>Fecha compra: </b>'.$filaPedido["tiempo_local_compra"].'</td>
            </tr>
            <tr>
                <th colspan="2">Direccion de envio</th>
                <th>Datos del pagador</th>
                <th colspan="2">Resumen compra</th>
            </tr>
            <tr>
                <td colspan="2">'.$filaDatos["nombre_apellido"].'</td>
                <td>'.$filaPedido["nombre_apellido_pagador"].'</td>
                <td colspan="2"><b>Precio total: </b>'.$filaPedido["precio_total"].'</td>
            </tr>
            <tr>
                <td colspan="2">'.$filaDatos["telefono"].'</td>
                <td>'.$filaPedido["email_pagador"].'</td>';
            
            $id_cupon = $filaPedido["id_cupon"];
            $consultaCupon = "SELECT *  FROM codigo_descuento WHERE id_cupon = '$id_cupon'";
            $resultadoCupon = $conexion->query($consultaCupon);

            if($resultadoCupon->num_rows > 0){
                $filaCupon = $resultadoCupon-> fetch_assoc();
                $tabla .= '<td colspan="2"><b>Codigo Descuento: </b>'.$filaPedido["id_cupon"].'->'.$filaCupon["porcentaje"].'%</td>';
            }else{
                $tabla .= '<td colspan="2"><b>Codigo Descuento:</b> </td>';
            }

            $tabla .= '</tr>
            <tr>
                <td colspan="2">'.$filaDatos["direccion"].'</td>
                <td></td>
                <td colspan="2"><b>Tras codigo deceunto:</b> '.$filaPedido["total_tras_codigo"].'</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2"><b>Porcentaje de iva:</b>'.$filaPedido["porcentaje_iva"].'%</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2"><b>Total final: </b>'.$filaPedido["total_final_con_iva"].'</td>
            </tr>
            <tr  class="facutra_centrado">
                <th colspan="5">Prodcutos</th>
            </tr>';


            $consultaProductos = "SELECT *  FROM compra_productos WHERE id_compra = '$pedido'";
            $resultadoProductos = $conexion->query($consultaProductos);
        
            if( $resultadoProductos->num_rows > 0) {
                
                if($tipo=="Compra"){
                    $tabla .= '<tr class="facutra_centrado">
                    <th colspan="2">Nombre</th>
                    <th>Catidad</th>
                    <th>Precio Individual</th>
                    <th>Precio Final Total</th>
                    </tr>';
                }else{
                    $tabla .= '<tr class="facutra_centrado">
                    <td></td>
                    <th>Nombre</th>
                    <th>Catidad</th>
                    <th>Precio Individual</th>
                    <th>Precio Final Total</th>
                    </tr>';
                
                }
            while ($filaProductos = $resultadoProductos-> fetch_assoc()){

                if($tipo=="Compra"){
                    $tabla .= '<tr class="facutra_centrado">';

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
                    $tabla .= '<tr class="facutra_centrado">
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