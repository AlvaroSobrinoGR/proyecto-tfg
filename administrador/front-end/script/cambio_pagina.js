window.addEventListener("load", funciones)

function funciones(){
    document.getElementById("informacionUsuario").addEventListener("click",cambio)
    document.getElementById("compras").addEventListener("click",cambio)
    document.getElementById("datosusuario").addEventListener("click",cambio)
    document.getElementById("descuentos").addEventListener("click",cambio)
    document.getElementById("codigosDescuento").addEventListener("click",cambio)
    document.getElementById("productos").addEventListener("click",cambio)
    document.getElementById("consultas").addEventListener("click",cambio)
    document.getElementById("incidencias").addEventListener("click",cambio)
    
    function cambio(){
        let nombre = this.id;
        switch (nombre) {
            case "informacionUsuario":
                window.location.href = "usuario.html"
                break;
            case "compras":
                window.location.href = "compras.html"
                break;
            case "datosusuario":
                window.location.href = "datos_usuario.html"
                break;
            case "descuentos":
                window.location.href = "descuentos.html"
                break;
            case "codigosDescuento":
                window.location.href = "codigos_descuento.html"
                break;
            case "productos":
                window.location.href = "productos.html"
                break;
            case "consultas":
                window.location.href = "consultas.html"
                break;
            case "incidencias":
                    window.location.href = "incidencias.html"
                    break;
        }

    }
}