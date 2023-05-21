<?php

require_once 'conexion_base_datos.php';


$conexion = conexionBaseDatos();
if(isset($_POST["id_producto"]) && isset($_POST["email"])){

    $id_producto = $_POST["id_producto"];
    $email = $_POST["email"];
    
    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($consulta);
    $id_usuario = "";
    if($resultado->num_rows > 0){

        while ($fila = $resultado-> fetch_assoc()){
            $id_usuario = $fila["id_usuario"];
        }

        $consulta = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
        $resultado = $conexion->query($consulta);

        if($resultado->num_rows > 0){
            $fila = $resultado-> fetch_assoc();
            if($fila["activo"] == 1 && $fila["stock"] == 0){
                $consulta = "SELECT * FROM avissos_disponibilidad WHERE id_usuario = '$id_usuario' AND id_producto = '$id_producto'";
                $resultado = $conexion->query($consulta);
        
                if($resultado->num_rows == 0){
                    $consulta = "INSERT INTO avissos_disponibilidad (id_usuario, id_producto)VALUES ('$id_usuario', '$id_producto')";
                    if( $conexion->query($consulta)==TRUE){
                        echo "Se le avisara por email cuando el producto este disponible";
                    }else{
                        echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
                    }
                
                }else{
                    echo "Se le avisara por email cuando el producto este disponible";
                }
            }else{
                echo "No se puede avisar de este producto";
            }

        }else{
            echo "El producto del que quiere ser avisado no existe";
        }
    
    }else{
        echo "Su email no esta registrado";
    }

}else{
    echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
}



$conexion->close();

?>