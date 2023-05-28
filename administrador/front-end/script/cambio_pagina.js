window.addEventListener("load", funciones)

function funciones(){
    document.getElementById("informacionUsuario").addEventListener("click",cambio)
    document.getElementById("consultas").addEventListener("click",cambio)
    document.getElementById("incidencias").addEventListener("click",cambio)
    document.getElementById("productos").addEventListener("click",cambio)

    function cambio(){
        let nombre = this.id;
        switch (nombre) {
            case "informacionUsuario":
                window.location.href = "usuario.html"
                break;
            case "consultas":
                
                break;
            case "incidencias":
                
                break;
            case "productos":
                
                break;
        }

    }
}