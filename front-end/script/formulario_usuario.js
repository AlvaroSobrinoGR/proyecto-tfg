window.addEventListener("load", funciones)

function funciones (){
    //cambio de formulario
    let formulario_usuario =  document.getElementById("formulario_usuario");
    let formulario_cambio_contrasena =  document.getElementById("formulario_cambio_contraseñia");
    

    //enviar informacion del formulario usuario
    document.getElementById("guardarCambios").addEventListener("click", conexion)

    document.getElementById("cambiarContraseña").addEventListener("click", conexion)


    function conexion() {
    let formulario = new FormData();
    if(this.id.includes("guardarCambios")){
        formulario.append("tipo", "configuracion");
        formulario.append("nombre", document.getElementById("nombre").value);
        formulario.append("direccion", document.getElementById("direccion").value);
        formulario.append("telefono", document.getElementById("telefono").value);
    }else{
        formulario.append("tipo", "contraseñia");
        if (localStorage.getItem("usuario")) {
            formulario.append("email", localStorage.getItem("usuario"))
        } else if (sessionStorage.getItem("usuario")){
            formulario.append("email", sessionStorage.getItem("usuario"))
        }
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/configuracion_usuario.php");
    xhr.addEventListener("load", (respuesta) => {
        if(respuesta.target.response.includes("exito")){
            document.getElementById("respuesta_contraeña").innerHTML="se te ha enviado un email para cambiar la contraseña"
        }else{
            document.getElementById("cuerpo").innerHTML = respuesta.target.response;
        }
    });
    xhr.send(formulario);
    }

    //enviar informacion de cambio contraseñia
    
}


/*
    1-tiene que mandarse todos los datos cuando se le de a guardar cambios
    2-tinen que mandarse lo cambios cuando se de a enviar en cambiar contraseñia

*/