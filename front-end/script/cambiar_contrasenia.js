window.addEventListener("load", funciones)

function funciones(){

    let queryParams = new URLSearchParams(window.location.search);
    if(queryParams.get('hash')==null || queryParams.get('email')==null){
        window.location.href = "inicio.html"
    }

    document.getElementById("cambiar_contraseñia").addEventListener("click", cambiar)

    function cambiar(){
        if(queryParams.get('hash')!=null && queryParams.get('email')!=null){
            let email = queryParams.get('email');
            let codigo = queryParams.get('hash');
            conexion(email, codigo, document.getElementById("confirmacion_contrasena").value)
        }else{
            document.getElementById("error").innerHTML="El link es incorecto"
        }
    }
    
    

    function conexion(email, codigo, contrasenia){
        let formulario = new FormData();
        formulario.append("email", email)
        formulario.append("codigo", codigo)
        formulario.append("contrasenia", contrasenia)


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/cambiar_contraseñia.php")
        xhr.addEventListener("load", (respuesta)=>{
            if(respuesta.target.response.includes("exito")){
                window.location.href = "inicio.html"
            }
        })

        xhr.send(formulario);
    }


}