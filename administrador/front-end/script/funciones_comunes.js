function saber_si_hay_usuario(){
    if (sessionStorage.getItem("usuario_tienda_minimalista")){
        return true;
    }else{
        return false;
    }
}

function obtener_usuario(){
    if (sessionStorage.getItem("usuario_tienda_minimalista")){
        return  sessionStorage.getItem("usuario_tienda_minimalista")
    }
}

function eliminar_usuario(){
    if (sessionStorage.getItem("usuario_tienda_minimalista")){
        return  sessionStorage.removeItem("usuario_tienda_minimalista")
    }
}