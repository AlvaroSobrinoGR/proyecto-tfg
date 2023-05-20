<?php
require_once 'conexion_base_datos.php';
$conexion = conexionBaseDatos();
try {
    $precio_total = 0;
    $id_cupon = $_POST["codigo_descuento"];
    $total_tras_cupon = 0;
    $porcentaje_iva = 21;
    $total_final_con_iva = 0;

  $productos_cantidades = $_POST["productos_cantidades"];
  $productos_cantidades = explode(";", $productos_cantidades);
  $productos_cantidades = array_slice($productos_cantidades, 1, -1);

  for ($i=0; $i < count($productos_cantidades); $i++) { 
      $temporal = explode("-", $productos_cantidades[$i]);//[0] producto [1] cantida
      $consulta = "SELECT * FROM productos WHERE id_producto = '$temporal[0]'";
      $resultado = $conexion->query($consulta);
      $fila = $resultado->fetch_assoc();
      $precio_total_prodcuto = (double)$fila["precio"]*(double)$temporal[1];
      //descuento del producto
      $porcentaje_descuento = 0;
      $consulta_descuento = "SELECT * FROM descuentos WHERE id_producto = $temporal[0]";
      $resultado_descuento = $conexion->query($consulta_descuento);
      if ($fila_descuento = $resultado_descuento->fetch_assoc()) {
        $porcentaje_descuento = $fila_descuento["porcentaje"];
      }
      $precio_total += $precio_total_prodcuto-($precio_total_prodcuto*$porcentaje_descuento/100);
  }

  $consulta = "SELECT * FROM codigo_descuento WHERE id_cupon = '$id_cupon'";
  $resultado = $conexion->query($consulta);

  if($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    if($fila["estado"] == 1){
      $total_tras_cupon = $precio_total-($precio_total*(double)$fila["porcentaje"]/100);
    }else{
      $id_cupon = "";
      $total_tras_cupon = $precio_total;
    }
  }else{
    $id_cupon = "";
    $total_tras_cupon = $precio_total;
  }

  $total_final_con_iva = $total_tras_cupon+($total_tras_cupon*$porcentaje_iva/100);

  echo $total_final_con_iva;
} catch (\Throwable $th) {
    echo "ha surgido un error al calcular el precio";
}

?>