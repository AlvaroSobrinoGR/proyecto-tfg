window.addEventListener("load", funciones)

function funciones (){
    //cambio de formulario
    let inicio_sesion =  document.getElementById("inicio_sesion");
    let resgistrarse =  document.getElementById("resgistrarse");
    let recuperar_cuenta =  document.getElementById("recuperar_cuenta");
    document.getElementById("boton_para_registrarse").addEventListener("click", cambiar_formulaio)
    document.getElementById("boton_para_iniciar_sesion").addEventListener("click", cambiar_formulaio)
    document.getElementById("olvido_contrasenia").addEventListener("click", cambiar_formulaio)
    document.getElementById("cancelar").addEventListener("click", cambiar_formulaio)
    
    function cambiar_formulaio(e){ //para cambiar el formulaio de inicio de sesion y de registro
        e.preventDefault()
        if(this.id.includes("iniciar")){
            inicio_sesion.style.display="block"
            resgistrarse.style.display="none"
            recuperar_cuenta.style.display="none"
            
        }else if(this.id.includes("registrarse")){
            inicio_sesion.style.display="none"
            resgistrarse.style.display="block"
            recuperar_cuenta.style.display="none"
        }else if(this.id.includes("olvido")){
            recuperar_cuenta.style.display="block"
            inicio_sesion.style.display="none"
            resgistrarse.style.display="none"
        }else{
            inicio_sesion.style.display="block"
            resgistrarse.style.display="none"
            recuperar_cuenta.style.display="none"
        }
    }

    //recuperar contrasenia
    document.getElementById("enviar_recuperacion").addEventListener("click", conexion_recuperacion)
    function conexion_recuperacion(){
        let formulario = new FormData();
        formulario.append("email", document.getElementById("email_recuperacion").value)
        document.getElementById("enviar_recuperacion").disabled = true;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/recuperar_cuenta.php")
        xhr.addEventListener("load", (respuesta)=>{
            let resultado = respuesta.target.response;
            if(resultado=="exito"){
                alert("Se te ha enviado un email para cambiar la contraseñia")
                window.location.href = "../index.html"
            }else{
                document.getElementById("respuesta_servidor").innerHTML = resultado;
            }
            document.getElementById("enviar_recuperacion").disabled = false;
        })
        xhr.send(formulario);
    }

    //enviar informacion del formulario
    document.getElementById("boton_iniciar_sesion").addEventListener("click", conexion)
    document.getElementById("boton_registrarse").addEventListener("click", conexion)
    function conexion(){
        let formulario = new FormData();
        let estado = true;
        if(this.id=="boton_iniciar_sesion"){
            formulario.append("tipo", "inicio")
            formulario.append("email", document.getElementById("email").value)
            formulario.append("contrasenia", document.getElementById("password").value)
            document.getElementById("boton_iniciar_sesion").disabled = true;
        }else{
            formulario.append("tipo", "creacion")
            if(verificarContraseñas() && verificarEmail()){
                formulario.append("email", document.getElementById("register-email").value)
                formulario.append("contrasenia", document.getElementById("register-password").value)
                formulario.append("contraseniaConfirmacion", document.getElementById("confirm-password").value)
                if(document.getElementsByName("novedades")[0].checked){
                    formulario.append("novedades", 1)
                }else{
                    formulario.append("novedades", 0)
                }
                document.getElementById("boton_registrarse").disabled = true;
            }else{
                comunicar_error()
                estado = false
            }
        }
        if(estado){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/formulario_iniciar_registrar_sesion.php")
            xhr.addEventListener("load", (respuesta)=>{
                let resultado = respuesta.target.response;
                if(this.id.includes("boton_iniciar_sesion")){
                    if(resultado.includes("La cuenta es correcta")){
                        if(document.getElementsByName("guardar_sesion")[0].checked){
                            localStorage.setItem("usuario_tienda_minimalista", resultado.split(";")[1])
                        }else{
                            sessionStorage.setItem("usuario_tienda_minimalista", resultado.split(";")[1])
                        }
                        //le llevo al inicio
                        window.location.href = "../index.html"
                    }else{
                        document.getElementById("respuesta_servidor").innerHTML=resultado;
                    }
                    document.getElementById("boton_iniciar_sesion").disabled = false;
                }else{
                    if(resultado.includes("exito")){
                        //localStorage.setItem("usuario", resultado.split(";")[1])
                        //le llevo al inicio
                        alert("Se te ha enviado un email para confirmar la cuenta")
                        window.location.href = "../index.html"
                    }else{
                        document.getElementById("respuesta_servidor").innerHTML=resultado;
                    }
                    document.getElementById("boton_registrarse").disabled = false;
                }
            })
            xhr.send(formulario);
        }
    }

    //mostrar contrasenia

    document.getElementById("mostrarContrasenia1").addEventListener("click", verContrasenia)
    document.getElementById("mostrarContrasenia2").addEventListener("click", verContrasenia)
    document.getElementById("mostrarContrasenia3").addEventListener("click", verContrasenia)
    function verContrasenia(e) {
        let passwordInput = "";
        if(this.id=="mostrarContrasenia1"){
            passwordInput = document.getElementById("password")
        }else if(this.id=="mostrarContrasenia2"){
            passwordInput = document.getElementById("register-password")
        }else{
            passwordInput = document.getElementById("confirm-password")
        }
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }


    function verificarContraseñas() {
        var password = document.getElementById("register-password").value;
        var confirmPassword = document.getElementById("confirm-password").value;
      
        var regex = /^(?=.*[A-Za-zÁÉÍÓÚÑáéíóúñ])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-zÁÉÍÓÚÑáéíóúñ\d@$!%*#?&]{6,}$/;
        /*
            ^ indica el inicio de la cadena.
            (?=.*[A-Za-z]) busca al menos un carácter alfabético en minúscula o mayúscula.
            (?=.*\d) busca al menos un número.
            (?=.*[@$!%*#?&]) busca al menos un signo (puedes agregar o quitar los signos que desees).
            [A-Za-z\d@$!%*#?&]{6,} verifica que la cadena tenga al menos 6 caracteres y solo contenga letras, números y los signos permitidos.
            $ indica el final de la cadena.
        */
        
        if (!regex.test(password)) {
          return false;
        }
      
        if (password !== confirmPassword) {
          return false;
        }
      
        // Si ambas contraseñas cumplen con el patrón y coinciden entre sí, puedes enviar los datos aquí
        // Código adicional para enviar los datos
      
        return true;
    }

    function verificarEmail() {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        /*
            ^ indica el inicio de la cadena.
            [^\s@]+ coincide con uno o más caracteres que no sean espacio en blanco ni el símbolo "@".
            @ coincide con el símbolo "@".
            [^\s@]+ coincide con uno o más caracteres que no sean espacio en blanco ni el símbolo "@".
            \. coincide con el símbolo ".".
            [^\s@]+ coincide con uno o más caracteres que no sean espacio en blanco ni el símbolo "@".
            $ indica el final de la cadena.
        */
        return regex.test(document.getElementById("register-email").value);
    }

    function comunicar_error() {
        var email = document.getElementById("register-email").value;
        var password = document.getElementById("register-password").value;
        var confirmPassword = document.getElementById("confirm-password").value;

        var regex = /^(?=.*[A-Za-zÁÉÍÓÚÑáéíóúñ])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-zÁÉÍÓÚÑáéíóúñ\d@$!%*#?&]{6,}$/;
      
        if (email.length == 0) {
            document.getElementById("error1").textContent = "No hay contenido";
          } else if (!verificarEmail(email)) {
            document.getElementById("error1").textContent = "Correo electrónico no válido";
          } else {
            document.getElementById("error1").textContent = "";
          }
        
          if (password.length == 0) {
            document.getElementById("error2").textContent = "No hay contenido";
          } else if (!regex.test(password)) {
            document.getElementById("error2").textContent = "Contraseña no válida. Debe tener al menos 6 caracteres, un número, un carácter alfabético y un signo especial (@$!%*#?&).";
          } else {
            document.getElementById("error2").textContent = "";
          }
        
          if (confirmPassword.length == 0) {
            document.getElementById("error3").textContent = "No hay contenido";
          } else if(confirmPassword != password){
            document.getElementById("error3").textContent = "Las dos contraseñias deben ser iguales";
          }else{
            document.getElementById("error3").textContent = "";
          }
      }
}
