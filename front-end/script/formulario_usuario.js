window.addEventListener("load", funciones)

function funciones (){
    //mostrar datos usuario
    conexionCargar()

    function conexionCargar() {
        let formulario = new FormData();
        let email = "";
        if (localStorage.getItem("usuario")) {
            email =  localStorage.getItem("usuario")
        } else if (sessionStorage.getItem("usuario")){
            email =  sessionStorage.getItem("usuario")
        }
        formulario.append("tipo", "cargar");
        formulario.append("email", email);
 
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/configuracion_usuario.php");
        xhr.addEventListener("load", (resultado) => {
            let respuesta = resultado.target.response
            //pintar datos
            document.getElementById("email").innerHTML = email;
            let json = JSON.parse(respuesta)
    
            document.getElementById("nombre").value = json[0]["nombre"]
            document.getElementById("direccion").value = json[0]["direccion"]
            document.getElementById("telefono").value = json[0]["telefono"]
            document.getElementsByName("novedades")[0].checked = json[0]["novedades"]==1?true:false;
             
        });
        xhr.send(formulario);
    }

    //enviar informacion del formulario usuario
    document.getElementById("guardarCambios").addEventListener("click", conexion)

    document.getElementById("cambiarContraseña").addEventListener("click", conexion)


    function conexion() {
    let formulario = new FormData();
    let email = "";

    if (localStorage.getItem("usuario")) {
        email =  localStorage.getItem("usuario")
    } else if (sessionStorage.getItem("usuario")){
        email =  sessionStorage.getItem("usuario")
    }

    if(this.id.includes("cambiarContraseña")){
        
        formulario.append("tipo", "contraseñia");
        formulario.append("email", email);

    }else if(this.id.includes("guardarCambios")){

        formulario.append("tipo", "configuracion");
        formulario.append("email", email);
        formulario.append("nombre", document.getElementById("nombre").value);
        formulario.append("direccion", document.getElementById("direccion").value);
        formulario.append("telefono", document.getElementById("telefono").value);
        formulario.append("novedades", document.getElementsByName("novedades")[0].checked?1:0);
        

    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/configuracion_usuario.php");
    xhr.addEventListener("load", (resultado) => {
        let respuesta = resultado.target.response
        if(respuesta.includes("exito_contra")){
            document.getElementById("respuesta_contraeña").innerHTML="se te ha enviado un email para cambiar la contraseña"
        }else{
            document.getElementById("cuerpo").innerHTML = respuesta;
        }
    });
    xhr.send(formulario);
    }

    //cerrar sesion
    document.getElementById("cerrar_sesion").addEventListener("click", cerrarSesion)
    function cerrarSesion (e){
        e.preventDefault()
        if (localStorage.getItem("usuario")) {
            localStorage.removeItem("usuario")
        } else if (sessionStorage.getItem("usuario")){
            sessionStorage.removeItem("usuario")
        }
        window.location.href = "inicio.html"
    }

    //consultas
    document.getElementById("consultas").addEventListener("click", listarConsultas)
    function listarConsultas(e){
        e.preventDefault()
        if(document.getElementById("lista_consultas").innerHTML.length>0){
            document.getElementById("lista_consultas").innerHTML=""
        }else{
            let formulario = new FormData();
            formulario.append("email", email);
     
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/usuario_consultas.php");
            xhr.addEventListener("load", (respuesta) => {
                let json = JSON.parse(respuesta.target.response)
                //pintar datos
                tabla = document.createElement("table")
                propiedades = ["id_consulta", "asunto", "consulta", "estado", "fecha"]
                tabla.setAttribute("id", "tabla_consultas")
    
                //lo que hago aquie es recorrer el arry al reves para pintar al principio de la tabla las consultas mas recientes
                for (let i = json.length-1; i >= 0; i--) {
                    tr = document.createElement("tr")
                    tr.setAttribute("id", "fila_consultas;"+(i-(json.length-1)))
                    //para evitar un codigo mas largo tengo las keys de las posiciones en el array propiedades y asi voy sacandolas en cada fila
                    for (let j = 0; j < Object.keys(json[i]).length; j++) {
                        td = document.createElement("td")
                        td.setAttribute("id", propiedades[j]+";"+(i-(json.length-1)))
                        td.innerHTML = json[i][propiedades[j]]
                        tr.appendChild(td)
                    }
                    tabla.appendChild(tr)
                }
                
                 document.getElementById("lista_consultas").appendChild(tabla)
            });
            xhr.send(formulario)
        }
    }
    
}
