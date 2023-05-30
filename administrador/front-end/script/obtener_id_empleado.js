window.addEventListener("load", funciones)

function funciones(){
    let formulario = new FormData();
    formulario.append("email_empleado", obtener_usuario());
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/obtener_id_empleado.php");
    xhr.addEventListener("load", (respuesta) => {
        if(respuesta.target.response.length > 0){
            document.getElementById("IDEmpleado").innerText = respuesta.target.response;
        }
    });
    xhr.send(formulario);
}