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
            conexion(email, codigo, document.getElementById("register-password").value, document.getElementById("confirm-password").value)
        }else{
            document.getElementById("error").innerHTML="El link es incorecto"
        }
    }
    
    

    function conexion(email, codigo, contrasenia, contraseniaConfirmar){
        if(verificarContraseñas()){
            let formulario = new FormData();
            formulario.append("email", email)
            formulario.append("codigo", codigo)
            formulario.append("contrasenia", contrasenia)
            formulario.append("contraseniaConfirmar", contraseniaConfirmar)


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/cambiar_contraseñia.php")
            xhr.addEventListener("load", (respuesta)=>{
                if(respuesta.target.response.includes("exito")){
                    alert("La contraseñia se ha cambiado")
                    window.location.href = "inicio.html"
                }else{
                    document.getElementById("errorServidor").innerHTML =respuesta.target.response
                }
            })
            xhr.send(formulario);
        }else{
            comunicar_error()
        }
        

        
    }

    function verificarContraseñas() {
        var password = document.getElementById("register-password").value;
        var confirmPassword = document.getElementById("confirm-password").value;
      
        var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/;
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

    function comunicar_error() {
        var password = document.getElementById("register-password").value;
        var confirmPassword = document.getElementById("confirm-password").value;

        var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/;
      
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

        //mostrar contrasenia

        document.getElementById("mostrarContrasenia1").addEventListener("click", verContrasenia)
        document.getElementById("mostrarContrasenia2").addEventListener("click", verContrasenia)
        function verContrasenia(e) {
            let passwordInput = "";
            if(this.id=="mostrarContrasenia1"){
                passwordInput = document.getElementById("register-password")
            }else if(this.id=="mostrarContrasenia2"){
                passwordInput = document.getElementById("confirm-password")
            }
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }


}