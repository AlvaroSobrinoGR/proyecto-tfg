<?php
$conexion = new mysqli("localhost", "root", "", "tienda");


$productos_cantidades = $_POST["productos_cantidades"];
$productos_cantidades = explode(";", $productos_cantidades);
$productos_cantidades = array_slice($productos_cantidades, 1, -1);

$encontrado = false;

for ($i=0; $i < count($productos_cantidades); $i++) {
    $temporal = explode("-", $productos_cantidades[$i]);//[0] producto [1] cantida
    $consulta = "SELECT * FROM productos WHERE id_producto = '$temporal[0]'";
    $resultado = $conexion->query($consulta);
    $fila = $resultado->fetch_assoc();
    $stock = $fila["stock"];
    if($stock==0){
        $nombre = $fila["nombre"];
        echo "el producto \"$nombre\" esta agotado en estos momentos";
        $encontrado = true;
    }else if($temporal[1]>$stock){
        $nombre = $fila["nombre"];
        echo "la cantidad de producto \"$nombre\" que quieres adquirir no esta disponible en el almacen.";
        $encontrado = true;
    }
    if($encontrado){
        break;
    }
}
echo "";

?>
