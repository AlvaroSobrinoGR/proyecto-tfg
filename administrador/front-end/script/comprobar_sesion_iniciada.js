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
        window.location.href = "../../index.html"
    } 

    function conexion(usuario){
        let formulario = new FormData();

        formulario.append("email", usuario)

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/comprobar_sesion_iniciada.php")
        xhr.addEventListener("load", (respuesta)=>{
            let resultado = respuesta.target.response;
            if(!resultado.includes("La cuenta si existe")){
                desplazar()
                if (saber_si_hay_usuario()) {
                    eliminar_usuario()
                }
            }else{
                sesionIniciada = true;
            }
        })
        xhr.send(formulario);
    }

}