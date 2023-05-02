window.addEventListener("load", funciones)

function funciones(){
    document.getElementById("enviar_comentario").addEventListener("click", conexion)
    function conexion(){
        let formulario = new FormData();
        formulario.append("asunto", document.getElementById("asunto").value)
        formulario.append("consulta", document.getElementById("consulta").value)
        let email = "";
        if (localStorage.getItem("usuario")) {
            email =  localStorage.getItem("usuario")
        } else if (sessionStorage.getItem("usuario")){
            email =  sessionStorage.getItem("usuario")
        }
        formulario.append("email", email)
        let fechaActual = new Date();
        let fechaActualFormateada = fechaActual.getFullYear() + '-' + (fechaActual.getMonth() + 1).toString().padStart(2, '0') + '-' + fechaActual.getDate().toString().padStart(2, '0') + ' ' + fechaActual.getHours().toString().padStart(2, '0') + ':' + fechaActual.getMinutes().toString().padStart(2, '0') + ':' + fechaActual.getSeconds().toString().padStart(2, '0');
        formulario.append("fecha", fechaActualFormateada)
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/contacto.php")
        xhr.addEventListener("load", (respuesta)=>{
            document.getElementById("formulario_contacto").innerHTML=respuesta.target.response;
        })
        xhr.send(formulario);
    }
}