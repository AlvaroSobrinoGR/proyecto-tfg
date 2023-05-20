window.addEventListener("load", funciones)


function funciones() {
    //comprobamos si habia una sesion iniciada o no.
    let sesionIniciada = false;

    function saberEstadoSesion(){
        return sesionIniciada;
    }

    //comprobar que el email esta bien
    if (saber_si_hay_usuario()) {  
        conexion(obtener_usuario())
    } else {
        //si el email no es valido borrar el localstorage y llamar a la funcion ocultar_contenido()
        ocultar_contenido()
    }  

    function ocultar_contenido(){//si la sesion no esta iniciada o esta mal
        let archivo_actual = window.location.pathname;
        if(archivo_actual.includes("index.html")){
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
            window.location.href = "../index.html"
        }
        if(archivo_actual.includes("carrito.html")){
            window.location.href = "../index.html"
        }
    }

    function conexion(usuario){
        let formulario = new FormData();

        formulario.append("email", usuario)

        let php = "back-end/comprobar_sesion_iniciada.php";
        if(!window.location.pathname.includes("index.html")){
            php = "../back-end/comprobar_sesion_iniciada.php";
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST", php)
        xhr.addEventListener("load", (respuesta)=>{
            let resultado = respuesta.target.response;
            if(!resultado.includes("La cuenta si existe")){
                ocultar_contenido()
                if (saber_si_hay_usuario()) {
                    eliminar_usuario()
                }
                if(!window.location.pathname.includes("index.html")){
                    window.location.href = "../index.html"
                }
                
            }else{
                sesionIniciada = true;
            }
        })
        xhr.send(formulario);
    }

}