window.addEventListener("load", functiones)
function funciones() {
    //comprobamos si habia una sesion iniciada o no.
    if (localStorage.getItem("usuario")) {
        //comprobar que el email esta bien

        //si el email no es valido borrar el localstorage y llamar a la funcion ocultar_contenido()
    } else {
        ocultar_contenido()
    }  

    function ocultar_contenido(){//si la sesion 

    }

}