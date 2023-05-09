<?php


$conexion = new mysqli("localhost", "root", "", "tienda");

$tipo = $_POST["tipo"];

if($tipo=="tipos"){
    $json = "[";

    //tipos de productos
    $consulta = "SELECT DISTINCT tipo, activo FROM productos;";
    $resultado = $conexion->query($consulta);


    while ($fila = $resultado-> fetch_assoc()){
        if($fila["activo"]==1){
            $json .= "\"".$fila["tipo"]."\",";
        }
    }
    $json = substr($json, 0, strlen($json)-1);
    echo $json."]";

}else{
    //productos
    $consulta;
    $resultado;
    if($tipo == "productos"){
        $consulta = "SELECT *  FROM productos";
        $resultado = $conexion->query($consulta);
    }else{
        $para = $_POST["para"];
        $forma = $_POST["forma"];
        if($para!="Todos los productos"){
            if($forma!="Sin orden"){
                if($forma == "Precio Ascendente"){
                    $consulta = "SELECT * FROM productos WHERE tipo = '$para' ORDER BY precio ASC;";
                    $resultado = $conexion->query($consulta);
                }else{
                    $consulta = "SELECT * FROM productos WHERE tipo = '$para' ORDER BY precio DESC;";
                    $resultado = $conexion->query($consulta);
                }
            }else{
                $consulta = "SELECT *  FROM productos WHERE tipo = '$para'";
                $resultado = $conexion->query($consulta);
            }
        }else{
            if($forma!="Sin orden"){
                if($forma == "Precio Ascendente"){
                    $consulta = "SELECT * FROM productos ORDER BY precio ASC;";
                    $resultado = $conexion->query($consulta);
                }else{
                    $consulta = "SELECT * FROM productos ORDER BY precio DESC;";
                    $resultado = $conexion->query($consulta);
                }
            }else{
                $consulta = "SELECT *  FROM productos";
                $resultado = $conexion->query($consulta);
            }
            
        }
    }



    

    $json = "[";
    while ($fila = $resultado-> fetch_assoc()){
        if($fila["activo"]==1){
            $json .= "{";
            $json .= "\"id_producto\" : \"".$fila["id_producto"]."\",";
            $json .= "\"nombre\" : \"".$fila["nombre"]."\",";
            $json .= "\"descripcion\" : \"".$fila["descripcion"]."\",";
            $json .= "\"stock\" : \"".($fila["stock"]>0?"1":"0")."\",";//1 hay stock 0 no hay stock
            $json .= "\"precio\" : \"".$fila["precio"]."\"";
            $json .= "},";
        }
    }
    $json = substr($json, 0, strlen($json)-1);
    echo $json."]";
    //recoger los datos de los productos y pintarlos como un array
    //recoger los adatos en json
//crear contenedores de imagen, nombre, descripcion

}





$conexion->close();



//inicio
//solo X producto y orden
?>