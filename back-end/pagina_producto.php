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
            if($fila["stock"] > 0){
                echo "stock 1";
            }else{
                echo "stock 0";
            }
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
