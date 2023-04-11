window.addEventListener("load", funciones)

function funciones(){
    document.getElementById("enviar_comentario").addEventListener("click", conexion)
    function conexion(){
        let formulario = new FormData();
        formulario.append("nombre", document.getElementById("nombre").value)
        formulario.append("email", document.getElementById("email").value)
        formulario.append("comentario", document.getElementById("comentario").value)
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/contacto.php")
        xhr.addEventListener("load", (respuesta)=>{
            document.getElementById("formulario_contacto").innerHTML=respuesta.target.response;
        })
        xhr.send(formulario);
    }
}