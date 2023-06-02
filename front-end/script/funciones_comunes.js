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

function pintarNumeroProductos(){
    if(sessionStorage.getItem("carrito_tienda_minimalista")){
        let productos = sessionStorage.getItem("carrito_tienda_minimalista").split(";")
        productos = productos.slice(1, -1);
        document.getElementById("numeroProductosCarrito").innerText = productos.length;
    }else{
        document.getElementById("numeroProductosCarrito").innerText = ""
    }
}
function numeroProductosCarrito(){
    if(sessionStorage.getItem("carrito_tienda_minimalista")){
        let productos = sessionStorage.getItem("carrito_tienda_minimalista").split(";")
        productos = productos.slice(1, -1);
        return productos.length;
    }else{
        return 0;
    }
}

/*bloqueo pantalla */

function desbloquearBloqueo(){
    document.getElementById('bloquePagina').style.display = "none";
}
function bloquearBloqueo(){
    document.getElementById('bloquePagina').style.display = "block";
}

function resizeDiv() {
    var windowHeight = window.innerHeight;
    var documentHeight = document.documentElement.scrollHeight;
    var height = Math.max(windowHeight, documentHeight);
    document.getElementById('bloquePagina').style.height = height + 'px';
  }
  
  window.addEventListener('resize', resizeDiv);
  document.addEventListener('DOMContentLoaded', resizeDiv);