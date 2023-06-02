window.addEventListener("load", funciones)

function funciones(){
    document.getElementById("enviar_comentario").addEventListener("click", conexion)
    function conexion(){
        bloquearBloqueo()
        let formulario = new FormData();
        let asunto = document.getElementById("asunto").value
        let consulta = document.getElementById("consulta").value
        if(asunto.length > 0 && consulta.length > 0){
            formulario.append("asunto", asunto)
            formulario.append("consulta", consulta)
            formulario.append("email", obtener_usuario())
            let fechaActual = new Date();
            let fechaActualFormateada = fechaActual.getFullYear() + '-' + (fechaActual.getMonth() + 1).toString().padStart(2, '0') + '-' + fechaActual.getDate().toString().padStart(2, '0') + ' ' + fechaActual.getHours().toString().padStart(2, '0') + ':' + fechaActual.getMinutes().toString().padStart(2, '0') + ':' + fechaActual.getSeconds().toString().padStart(2, '0');
            formulario.append("fecha", fechaActualFormateada)
            document.getElementById("enviar_comentario").disabled = true;
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/contacto.php")
            xhr.addEventListener("load", (respuesta)=>{
                alert(respuesta.target.response)
                document.getElementById("enviar_comentario").disabled = false
                desbloquearBloqueo()
            })
            xhr.send(formulario);
        }else{
            alert("Tanto el asunto como la consulta deben tener contenido.")
            desbloquearBloqueo()
        }
        
    }
}