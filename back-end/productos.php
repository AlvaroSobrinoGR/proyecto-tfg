<?php

require_once 'conexion_base_datos.php';

$conexion = conexionBaseDatos();
if(isset($_POST["tipo"])){

    $tipo = $_POST["tipo"];
    $ordenArray = "";
    
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
            if(isset($_POST["para"]) && isset($_POST["forma"])){
                $para = $_POST["para"];
                $forma = $_POST["forma"];
                $ordenArray = $forma;
                
                $consulta = "SELECT * FROM productos";
                if ($para != "Todos los productos") {
                    $consulta .= " WHERE tipo = '$para'";
                }
                $resultado = $conexion->query($consulta);
                
                /* antes
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
                    
                }*/
            }else{
                echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
            }
            
        }
    
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            if ($fila["activo"] == 1) {
                //saco si este producto tiene algun descuento 
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
    
                $datos[] = array(
                    "id_producto" => $fila["id_producto"],
                    "nombre" => $fila["nombre"],
                    "descripcion" => addslashes($fila["descripcion"]),
                    "stock" => ($fila["stock"] > 0 ? "1" : "0"),
                    "precio" => $fila["precio"],
                    "descuento" => $descuento,
                    "precio_con_descuento" => number_format($precio_con_descuento, 2, '.', '') 
                );
            }
        }
    
        //oredenar array
        if($ordenArray == "Precio Ascendente"){
            usort($datos, function($a, $b) {
                return $a["precio_con_descuento"] <=> $b["precio_con_descuento"];
            });
        } else if ($ordenArray == "Precio Descendente") {
            usort($datos, function($a, $b) {
                return $b["precio_con_descuento"] <=> $a["precio_con_descuento"];
            });
        }
    
        $json = "[";
    
        foreach ($datos as $item) {
            $json .= "{";
            foreach ($item as $key => $value) {
                $json .= "\"".$key."\" : \"".$value."\",";
            }
            $json = substr($json, 0, strlen($json)-1);
            $json .= "},";
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json.="]";
    
        /* imprimir json
        $json = "[";
        while ($fila = $resultado-> fetch_assoc()){
            if($fila["activo"]==1){
                //saco si este producto tiene algun descuento 
                $id_producto = $fila["id_producto"];
                $consulta_descuento = "SELECT * FROM descuentos WHERE id_producto = $id_producto";
                $resultado_descuento = $conexion->query($consulta_descuento);
                $descuento;
                if ($fila_descuento = $resultado_descuento->fetch_assoc()) {
                    $descuento = $fila_descuento["porcentaje"];
                } else {
                    $descuento = 0;
                }
    
    
                $json .= "{";
                $json .= "\"id_producto\" : \"".$fila["id_producto"]."\",";
                $json .= "\"nombre\" : \"".$fila["nombre"]."\",";
                $json .= "\"descripcion\" : \"".$fila["descripcion"]."\",";
                $json .= "\"stock\" : \"".($fila["stock"]>0?"1":"0")."\",";//1 hay stock 0 no hay stock
                $json .= "\"precio\" : \"".$fila["precio"]."\",";
                $json .= "\"descuento\" : \"".$descuento."\"";
                $json .= "},";
            }
        }
        $json = substr($json, 0, strlen($json)-1);
        echo $json."]";
        */
    
        //recoger los datos de los productos y pintarlos como un array
        //recoger los adatos en json
    //crear contenedores de imagen, nombre, descripcion
    
    }
    
}else{
    echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
}


$conexion->close();



//inicio
//solo X producto y orden
?>