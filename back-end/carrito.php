<?php
    
    $carrito = $_POST["carrito"];
    $productos = explode(";", $carrito);
    $productos = array_slice($productos, 1, -1);


    $conexion = new mysqli("localhost", "root", "", "tienda");

    $consulta = "SELECT *  FROM productos WHERE ";
    for ($i=0; $i < count($productos); $i++) {
        if($i>0){
            $consulta.= " OR ";
        }
        $consulta.="id_producto = '$productos[$i]'";
    }
    $resultado = $conexion->query($consulta);
    
    $json = "[";
    
    while ($fila = $resultado-> fetch_assoc()){
        if($fila["activo"]==1){

            $id_producto = $fila["id_producto"];
            $consulta_descuento = "SELECT * FROM descuentos WHERE id_producto = $id_producto";
            $resultado_descuento = $conexion->query($consulta_descuento);
            $descuento;
            if ($fila_descuento = $resultado_descuento->fetch_assoc()) {
                $descuento = $fila_descuento["porcentaje"];
            } else {
                $descuento = 0;
            }

            $precio_con_descuento = floatval($fila["precio"] - ($fila["precio"] * $descuento / 100));

            $json .= "{";
            $json .= "\"id_producto\" : \"".$fila["id_producto"]."\",";
            $json .= "\"nombre\" : \"".$fila["nombre"]."\",";
            $json .= "\"precio\" : \"".$fila["precio"]."\",";
            $json .= "\"stock\" : \"".($fila["stock"]>0?"1":"0")."\",";//1 hay stock 0 no hay stock
            $json .= "\"descuento\" : \"".$descuento."\",";
            $json .= "\"precio_con_descuento\" : \"".number_format($precio_con_descuento, 2, '.', '')."\"";
            $json .= "},";
        }
    }
    $json = substr($json, 0, strlen($json)-1);
    echo $json."]";


    $conexion->close();

?>