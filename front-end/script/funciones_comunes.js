function saber_si_hay_usuario(){
    if (localStorage.getItem("usuario_tienda_minimalista")) {
        return true;
    } else if (sessionStorage.getItem("usuario_tienda_minimalista")){
        return true;
    }else{
        return false;
    }
}

function obtener_usuario(){
    if (localStorage.getItem("usuario_tienda_minimalista")) {
        return  localStorage.getItem("usuario_tienda_minimalista")
    } else if (sessionStorage.getItem("usuario_tienda_minimalista")){
        return  sessionStorage.getItem("usuario_tienda_minimalista")
    }
}

function eliminar_usuario(){
    if (localStorage.getItem("usuario_tienda_minimalista")) {
        return  localStorage.removeItem("usuario_tienda_minimalista")
    } else if (sessionStorage.getItem("usuario_tienda_minimalista")){
        return  sessionStorage.removeItem("usuario_tienda_minimalista")
    }
}