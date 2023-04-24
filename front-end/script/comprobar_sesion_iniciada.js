window.addEventListener("load", funciones)
function funciones() {
    //comprobamos si habia una sesion iniciada o no.
    if (localStorage.getItem("usuario")) {
        //comprobar que el email esta bien
        conexion()
        
        //si el email no es valido borrar el localstorage y llamar a la funcion ocultar_contenido()
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
    }

    function conexion(){
        let formulario = new FormData();
        formulario.append("email", localStorage.getItem("usuario"))

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/comprobar_sesion_iniciada.php")
        xhr.addEventListener("load", (respuesta)=>{
            let resultado = respuesta.target.response;
            if(resultado.includes("La cuenta si existe")){
                //no hacer cambios
            }else{
                ocultar_contenido()
            }
        })
        xhr.send(formulario);
    }

}