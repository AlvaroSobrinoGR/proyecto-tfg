window.addEventListener("load", funciones)

function funciones(){
    document.getElementById("inicio_registro_sesion").addEventListener("click", cambiar)
    function cambiar(){
        window.location.href = "iniciar_registrar_sesion.html"
    }
}