window.addEventListener("load", funciones)
function funciones() {
    //comprobamos si habia una sesion iniciada o no.
    let sesionIniciada = false;

    function saberEstadoSesion(){
        return sesionIniciada;
    }
    
    if (localStorage.getItem("usuario")) {
        //comprobar que el email esta bien
        conexion(localStorage.getItem("usuario"))
        //si el email no es valido borrar el localstorage y llamar a la funcion ocultar_contenido()
    } else if (sessionStorage.getItem("usuario")){
        conexion(sessionStorage.getItem("usuario"))
    } else {
        
        ocultar_contenido()
    }  

    function ocultar_contenido(){//si la sesion no esta iniciada o esta mal
        let archivo_actual = window.location.pathname;
        if(archivo_actual.includes("inicio.html")){
            document.getElementById("seccion_usuario").style.display="none";
            document.getElementById("seccion_carrito").style.display="none";
            document.getElementById("inicio_registro_sesion").style.display="block";
        }
        if(archivo_actual.includes("contacto.html")){
            document.getElementById("seccion_usuario").style.display="none";
            document.getElementById("seccion_carrito").style.display="none";
            document.getElementById("formulario_contacto").style.display="none";
            document.getElementById("sesion_no_iniciada").style.display = "block";
            document.getElementById("inicio_registro_sesion").style.display="block";
            
        }
        if(archivo_actual.includes("productos.html")){
            document.getElementById("seccion_usuario").style.display="none";
            document.getElementById("seccion_carrito").style.display="none";
            document.getElementById("inicio_registro_sesion").style.display="block";
        }
        if(archivo_actual.includes("usuario.html")){
            window.location.href = "inicio.html"
        }
        if(archivo_actual.includes("carrito.html")){
            window.location.href = "inicio.html"
        }
    }

    function conexion(usuario){
        let formulario = new FormData();
        formulario.append("email", usuario)

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/comprobar_sesion_iniciada.php")
        xhr.addEventListener("load", (respuesta)=>{
            let resultado = respuesta.target.response;
            if(!resultado.includes("La cuenta si existe")){
                ocultar_contenido()
                if (localStorage.getItem("usuario")) {
                    localStorage.removeItem("usuario")
                } else if (sessionStorage.getItem("usuario")){
                    sessionStorage.removeItem("usuario")
                }
                window.location.href = "inicio.html"
            }else{
                sesionIniciada = true;
            }
        })
        xhr.send(formulario);
    }

}