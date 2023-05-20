window.addEventListener("load", funciones)

function funciones(){
    document.getElementById("inicio_registro_sesion").addEventListener("click", cambiar)
    function cambiar(){
        if(window.location.pathname.includes("index.html")){
            window.location.href = "front-end/iniciar_registrar_sesion.html"
        }else{
            window.location.href = "iniciar_registrar_sesion.html"
        }
        
    }
}