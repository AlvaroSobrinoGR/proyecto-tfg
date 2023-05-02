<?php


$conexion = new mysqli("localhost", "root", "", "tienda");

$consulta = "SELECT *  FROM productos";
$resultado = $conexion->query($consulta);

$json = "[";

while ($fila = $resultado-> fetch_assoc()){
    if($fila["activo"]==1){
        $json .= "{";
        $json .= "\"id_producto\" : \"".$fila["id_producto"]."\",";
        $json .= "\"nombre\" : \"".$fila["nombre"]."\",";
        $json .= "\"descripcion\" : \"".$fila["descripcion"]."\",";
        $json .= "\"stock\" : \"".($fila["stock"]>0?"1":"0")."\"";//1 hay stock 0 no hay stock
        $json .= "},";
    }
}
$json = substr($json, 0, strlen($json)-1);
echo $json."]";
//recoger los datos de los productos y pintarlos como un array
//recoger los adatos en json
//crear contenedores de imagen, nombre, descripcion

$conexion->close();
?>