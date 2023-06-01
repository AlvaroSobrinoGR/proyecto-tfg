<?php
require_once 'envio_de_correos.php'; 
require_once 'conexion_base_datos.php';

//try {
        
    $conexion = conexionBaseDatos();
    if(isset($_POST['email']) && isset($_POST['id_pedido']) && isset($_POST['asunto']) && isset($_POST['consulta']) && isset($_POST['fecha'])){
        $email = $_POST['email'];
        $id_pedido = (int)$_POST['id_pedido'];
        $asunto = $_POST['asunto'];
        $consulta = $_POST['consulta'];
        $fecha = $_POST['fecha'];

        if(strlen(addslashes($asunto)) <= 255 && strlen(addslashes($consulta)) <= 255){
            if(strlen(addslashes($asunto)) >0 && strlen(addslashes($consulta)) > 0){
                $sql = "SELECT id_usuario FROM usuarios WHERE email = '$email'";

            $resultado = $conexion->query($sql);
    
            $id_usuario = $resultado-> fetch_assoc()["id_usuario"];
    
            $sql = "SELECT * FROM compra WHERE id_usuario = '$id_usuario' AND id_compra = '$id_pedido'";
    
            $resultado = $conexion->query($sql);
            if($resultado->num_rows > 0){
                $estado = "espera";
            
                $sql = "INSERT INTO incidencias (id_compra, asunto, consulta, estado, fecha) VALUES ('$id_pedido', '$asunto', '$consulta', '$estado', '$fecha')";
                /*
                espera: aun no ha sido atendida
                trabajando: se esta trabajando en ella
                finalizada: consulta cerrada
                */
                if ($conexion->query($sql) == TRUE) {
                try {
                    $ultimo_id = mysqli_insert_id($conexion);
                
                    $resultado = enviarCorreo($email, "$asunto. Id incidencia: $ultimo_id" , "Codigo de la incidencia: $ultimo_id <br><br>Fecha: $fecha <br><br>Estado: espera.<br><br> Le responderemos su incidencia por este email.<br><br>Incidencia: $consulta");
                } catch (Throwable $t) {
                    echo "Ha ocurrido un error: " . $t->getMessage();
                }
                
                if($resultado=="enviado"){
                    echo "La incidencia ha sido creada. Recibirá un email con los detalles.";
                }else{
                    $sql = "DELETE FROM incidencias WHERE id_incidencia = '$ultimo_id'";
                    $conexion->query($sql);
                    echo "el email no se ha enviado";
                }
                } else {
                echo "Error al crear la incidencia: ";
                }
            }else{
                echo "Error: el id de compra o el usario esta mal";
            }
            }else{
                echo "Tanto el asunto como la consulta deben tener contenido.";
              }
            
        }else{
            echo "Tanto el asunto como el contenido de la consulta no pueden superar los 255 caracteres.";
        }

        
    }else{
        echo "Algo ha fallado. Inténtelo de nuevo más tarde.";
    }

    
/*} catch (\Throwable $th) {
    echo "Ha surgido alguna clase error en el servidor".$th->getMessage();;
}*/
  
$conexion->close();
?>