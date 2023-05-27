<?php
require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();

if(isset($_POST["id_producto"])){
    $id_producto = $_POST["id_producto"];
    $consulta = "SELECT *  FROM productos WHERE id_producto = '$id_producto'";
    $resultado = $conexion->query($consulta);
    if($resultado->num_rows>0){
        $fila = $resultado->fetch_assoc();
        if($fila["activo"] == 1){
            $json = "[";
            $json .= "{";
            $json .= "\"precio\" : \"".$fila["precio"]."\",";
            $json .= "\"stock\" : \"".($fila["stock"] > 0 ? "1" : "0")."\",";

            $id_producto = $fila["id_producto"];
            $consulta_descuento = "SELECT * FROM descuentos WHERE id_producto = $id_producto";
            $resultado_descuento = $conexion->query($consulta_descuento);
            $descuento;
            if ($fila_descuento = $resultado_descuento->fetch_assoc()) {
                $descuento = $fila_descuento["porcentaje"];
            } else {
                $descuento = 0;
            }

            $json .= "\"descuento\" : \"".$descuento."\",";
            
            $precio_con_descuento = floatval($fila["precio"] - ($fila["precio"] * $descuento / 100));

            $json .= "\"precio_con_descuento\" : \"".$precio_con_descuento."\"";

            $json .= "}";
            echo $json.="]";
        }else{
            echo "no activo";
        }
    }else{
        echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
    }
}else{
    echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
}
$conexion->close();
?>
