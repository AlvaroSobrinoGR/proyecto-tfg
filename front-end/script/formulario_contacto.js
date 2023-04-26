window.addEventListener("load", funciones)

function funciones(){
    document.getElementById("enviar_comentario").addEventListener("click", conexion)
    function conexion(){
        let formulario = new FormData();
        formulario.append("asunto", document.getElementById("asunto").value)
        formulario.append("consulta", document.getElementById("consulta").value)
        formulario.append("email", localStorage.getItem("usuario"))
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/contacto.php")
        xhr.addEventListener("load", (respuesta)=>{
            document.getElementById("formulario_contacto").innerHTML=respuesta.target.response;
        })
        xhr.send(formulario);
    }
}