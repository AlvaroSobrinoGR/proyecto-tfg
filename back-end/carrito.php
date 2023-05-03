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
            $json .= "{";
            $json .= "\"id_producto\" : \"".$fila["id_producto"]."\",";
            $json .= "\"nombre\" : \"".$fila["nombre"]."\",";
            $json .= "\"precio\" : \"".$fila["precio"]."\",";
            $json .= "\"stock\" : \"".($fila["stock"]>0?"1":"0")."\"";//1 hay stock 0 no hay stock
            $json .= "},";
        }
    }
    $json = substr($json, 0, strlen($json)-1);
    echo $json."]";


    $conexion->close();

?>