window.addEventListener("load", funciones)

function funciones (){
    //mostrar datos usuario
    conexionCargar()

    function conexionCargar() {
        let formulario = new FormData();
        let email = "";
        if (localStorage.getItem("usuario")) {
            email =  localStorage.getItem("usuario")
        } else if (sessionStorage.getItem("usuario")){
            email =  sessionStorage.getItem("usuario")
        }
        formulario.append("tipo", "cargar");
        formulario.append("email", email);
 
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/configuracion_usuario.php");
        xhr.addEventListener("load", (resultado) => {
            let respuesta = resultado.target.response
            //pintar datos
            document.getElementById("email").innerHTML = email;
            let json = JSON.parse(respuesta)
    
            document.getElementById("nombre").value = json[0]["nombre"]
            document.getElementById("direccion").value = json[0]["direccion"]
            document.getElementById("telefono").value = json[0]["telefono"]
            document.getElementsByName("novedades")[0].checked = json[0]["novedades"]==1?true:false;
             
        });
        xhr.send(formulario);
    }

    //enviar informacion del formulario usuario
    document.getElementById("guardarCambios").addEventListener("click", conexion)

    document.getElementById("cambiarContraseña").addEventListener("click", conexion)


    function conexion() {
    let formulario = new FormData();
    let email = "";

    if (localStorage.getItem("usuario")) {
        email =  localStorage.getItem("usuario")
    } else if (sessionStorage.getItem("usuario")){
        email =  sessionStorage.getItem("usuario")
    }

    if(this.id.includes("cambiarContraseña")){
        
        formulario.append("tipo", "contraseñia");
        formulario.append("email", email);

    }else if(this.id.includes("guardarCambios")){

        formulario.append("tipo", "configuracion");
        formulario.append("email", email);
        formulario.append("nombre", document.getElementById("nombre").value);
        formulario.append("direccion", document.getElementById("direccion").value);
        formulario.append("telefono", document.getElementById("telefono").value);
        formulario.append("novedades", document.getElementsByName("novedades")[0].checked?1:0);
        

    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/configuracion_usuario.php");
    xhr.addEventListener("load", (resultado) => {
        let respuesta = resultado.target.response
        if(respuesta.includes("exito_contra")){
            document.getElementById("respuesta_contraeña").innerHTML="se te ha enviado un email para cambiar la contraseña"
        }else{
            document.getElementById("cuerpo").innerHTML = respuesta;
        }
    });
    xhr.send(formulario);
    }

    //cerrar sesion
    document.getElementById("cerrar_sesion").addEventListener("click", cerrarSesion)
    function cerrarSesion (e){
        e.preventDefault()
        if (localStorage.getItem("usuario")) {
            localStorage.removeItem("usuario")
        } else if (sessionStorage.getItem("usuario")){
            sessionStorage.removeItem("usuario")
        }
        window.location.href = "inicio.html"
    }

    //consultas
    document.getElementById("consultas").addEventListener("click", listarConsultas)
    function listarConsultas(e){
        e.preventDefault()
        let formulario = new FormData();
        formulario.append("email", email);
 
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/usuario_consultas.php");
        xhr.addEventListener("load", (resultado) => {
            let respuesta = resultado.target.response
            //pintar datos
            let json = JSON.parse(respuesta)

            console.log(json)
             
        });
        xhr.send(formulario);
    }
    
}
