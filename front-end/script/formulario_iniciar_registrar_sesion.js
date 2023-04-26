window.addEventListener("load", funciones)

function funciones (){
    //cambio de formulario
    let inicio_sesion =  document.getElementById("inicio_sesion");
    let resgistrarse =  document.getElementById("resgistrarse");
    document.getElementById("boton_para_registrarse").addEventListener("click", cambiar_formulaio)
    document.getElementById("boton_para_iniciar_sesion").addEventListener("click", cambiar_formulaio)
    
    function cambiar_formulaio(e){ //para cambiar el formulaio de inicio de sesion y de registro
        e.preventDefault()
        if(this.id.includes("iniciar")){
            inicio_sesion.style.display="block"
            resgistrarse.style.display="none"
            
        }else{
            inicio_sesion.style.display="none"
            resgistrarse.style.display="block"
        }
    }

    //enviar informacion del formulario
    document.getElementById("boton_iniciar_sesion").addEventListener("click", conexion)
    document.getElementById("boton_registrarse").addEventListener("click", conexion)
    function conexion(){
        let formulario = new FormData();
        if(this.id=="boton_iniciar_sesion"){
            formulario.append("tipo", "inicio")
            formulario.append("email", document.getElementById("email").value)
            formulario.append("contrasenia", document.getElementById("password").value)
        }else{
            formulario.append("tipo", "creacion")
            formulario.append("email", document.getElementById("register-email").value)
            formulario.append("contrasenia", document.getElementById("register-password").value)
        }
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/formulario_iniciar_registrar_sesion.php")
        xhr.addEventListener("load", (respuesta)=>{
            let resultado = respuesta.target.response;
            if(this.id.includes("boton_iniciar_sesion")){
                if(resultado.includes("La cuenta es correcta")){
                    localStorage.setItem("usuario", resultado.split(";")[1])
                    //le llevo al inicio
                    //window.location.href = "inicio.html"
                }else{
                    document.getElementById("respuesta_servidor").innerHTML=resultado;
                }
            }else{
                if(resultado.includes("Cuenta creada exitosamente")){
                    localStorage.setItem("usuario", resultado) //resultado.split(";")[1]
                    //le llevo al inicio
                    //window.location.href = "inicio.html"
                }else{
                    document.getElementById("respuesta_servidor").innerHTML=resultado;
                }
            }
        })
        xhr.send(formulario);
    }
}
