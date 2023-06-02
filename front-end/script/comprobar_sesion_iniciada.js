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
    }else{
        desplazar()
        
    }
    function desplazar(){
        let archivo_actual = window.location.pathname;
        if(archivo_actual.includes("usuario.html")){
            window.location.href = "../index.html"
        }
        if(archivo_actual.includes("carrito.html")){
            window.location.href = "../index.html"
        }
    }
    function desocultar_contenido(){//si la sesion no esta iniciada o esta mal
        let archivo_actual = window.location.pathname;
        if(archivo_actual.includes("index.html")){
            document.getElementById("seccion_usuario").style.display="block";
            document.getElementById("seccion_carrito").style.display="block";
            document.getElementById("inicio_registro_sesion").style.display="none";
        }
        if(archivo_actual.includes("contacto.html")){
            document.getElementById("seccion_usuario").style.display="block";
            document.getElementById("seccion_carrito").style.display="block";
            document.getElementById("formulario_contacto").style.display="block";
            document.getElementById("sesion_no_iniciada").style.display = "none";
            document.getElementById("inicio_registro_sesion").style.display="none";
            
        }
        if(archivo_actual.includes("productos.html")){
            document.getElementById("seccion_usuario").style.display="block";
            document.getElementById("seccion_carrito").style.display="block";
            document.getElementById("inicio_registro_sesion").style.display="none";
        }
        if(archivo_actual.includes("paginaProducto")){
            document.getElementById("seccion_usuario").style.display="block";
            document.getElementById("seccion_carrito").style.display="block";
            document.getElementById("inicio_registro_sesion").style.display="none";
        }
        if(archivo_actual.includes("usuario")){
            document.getElementById("seccion_usuario").style.display="block";
            document.getElementById("seccion_carrito").style.display="block";
            document.getElementById("inicio_registro_sesion").style.display="none";
        }
        if(archivo_actual.includes("carrito")){
            document.getElementById("seccion_usuario").style.display="block";
            document.getElementById("seccion_carrito").style.display="block";
            document.getElementById("inicio_registro_sesion").style.display="none";
        }
        
    }

    function conexion(usuario){
        let formulario = new FormData();

        formulario.append("email", usuario)

        let php = "back-end/comprobar_sesion_iniciada.php";
        if(!window.location.pathname.includes("index.html") && !window.location.pathname.includes("paginaProducto")){
            php = "../back-end/comprobar_sesion_iniciada.php";
        }else if(window.location.pathname.includes("paginaProducto")){
            php = "../../../back-end/comprobar_sesion_iniciada.php";
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST", php)
        xhr.addEventListener("load", (respuesta)=>{
            let resultado = respuesta.target.response;
            if(!resultado.includes("La cuenta si existe")){
                desplazar()
                if (saber_si_hay_usuario()) {
                    eliminar_usuario()
                }
                if(!window.location.pathname.includes("index.html") && !window.location.pathname.includes("paginaProducto")){
                    window.location.href = "../index.html"
                }else if(window.location.pathname.includes("paginaProducto")){
                    window.location.href = "../../../index.html"
                }
            }else{
                desocultar_contenido()
                sesionIniciada = true;
            }
        })
        xhr.send(formulario);
    }

}