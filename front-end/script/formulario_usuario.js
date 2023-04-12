window.addEventListener("load", funciones)

function funciones (){
    //cambio de formulario
    let formulario_usuario =  document.getElementById("formulario_usuario");
    let formulario_cambio_contrasena =  document.getElementById("formulario_cambio_contraseñia");
    document.getElementById("cambiarContraseña").addEventListener("click", cambiar_formulaio)
    document.getElementById("cancelar").addEventListener("click", cambiar_formulaio)
    
    function cambiar_formulaio(){ //para cambiar el formulaio de inicio de sesion y de registro
        if(this.id.includes("cancelar")){
            formulario_usuario.style.display="block"
            formulario_cambio_contrasena.style.display="none"
        }else{
            formulario_usuario.style.display="none"
            formulario_cambio_contrasena.style.display="block"
        }
    }

    //enviar informacion del formulario usuario
    document.getElementById("guardarCambios").addEventListener("click", conexion)
    document.getElementById("cambiarContraseñia").addEventListener("click", conexion)
    function conexion() {
    let formulario = new FormData();
    if(this.id.includes("guardarCambios")){
        formulario.append("tipo", "configuracion");
        formulario.append("nombre", document.getElementById("nombre").value);
        formulario.append("direccion", document.getElementById("direccion").value);
        formulario.append("telefono", document.getElementById("telefono").value);
    }else{
        formulario.append("tipo", "contraseñia");
        formulario.append("contraAntigua", document.getElementById("antigua-contrasena").value);
        formulario.append("contraNueva", document.getElementById("nueva-contrasena").value);
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/configuracion_usuario.php");
    xhr.addEventListener("load", (respuesta) => {
        document.getElementById("cuerpo").innerHTML = respuesta.target.response;
    });
    xhr.send(formulario);
    }

    //enviar informacion de cambio contraseñia
    
}


/*
    1-tiene que mandarse todos los datos cuando se le de a guardar cambios
    2-tinen que mandarse lo cambios cuando se de a enviar en cambiar contraseñia

*/