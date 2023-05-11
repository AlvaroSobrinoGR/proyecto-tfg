<?php
  $conexion = new mysqli("localhost", "root", "", "tienda");
  
  $codigo = $_POST["codigoDescuento"];
  
  $consulta = "SELECT * FROM codigo_descuento WHERE BINARY id_cupon = '$codigo'"; //EL BINARY es para evitar que no esta distinguiendo entre mayusculas y minusculas
  $resultado = $conexion->query($consulta);

  $porcentajeDescuneto = 0;

  if($resultado->num_rows > 0) {
    while ($fila = $resultado-> fetch_assoc()){
      if($fila["estado"]==1){
        $porcentajeDescuneto = $fila["porcentaje"];
        echo $porcentajeDescuneto;
      }else if($fila["estado"]==0){
        echo "el codigo esta desabilitado";
      }
    }
  }else{
    echo "el codigo no existe";
  }


  $conexion->close();
?>