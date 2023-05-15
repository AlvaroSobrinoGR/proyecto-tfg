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
            let email
            if (localStorage.getItem("usuario")) {
                email = localStorage.getItem("usuario")
            } else if (sessionStorage.getItem("usuario")){
                email = sessionStorage.getItem("usuario")
            }
            let formulario = new FormData();
            formulario.append("email", email);
     
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/usuario_consultas.php");
            xhr.addEventListener("load", (respuesta) => {
                let json = JSON.parse(respuesta.target.response)
                //pintar datos
                tabla = document.createElement("table")
                tabla.innerHTML = '<tr><th>Id consulta</th><th>Asunto</th><th>Consulta</th><th>Estado</th><th>Fecha</th></tr>'
                propiedades = ["id_consulta", "asunto", "consulta", "estado", "fecha"]
                tabla.setAttribute("id", "tabla_consultas")
    
                //lo que hago aquie es recorrer el arry al reves para pintar al principio de la tabla las consultas mas recientes
                for (let i = json.length-1; i >= 0; i--) {
                    tr = document.createElement("tr")
                    tr.setAttribute("id", "fila_consultas;"+(i-(json.length-1)))
                    //para evitar un codigo mas largo tengo las keys de las posiciones en el array propiedades y asi voy sacandolas en cada fila
                    for (let j = 0; j < Object.keys(json[i]).length; j++) {
                        td = document.createElement("td")
                        td.setAttribute("id", propiedades[j]+";"+((json.length-1)-i))
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

    //pedidos
    document.getElementById("pedidos").addEventListener("click", listarPedidos)
    function listarPedidos(e){
        e.preventDefault()
        if(document.getElementById("lista_pedidos").innerHTML.length>0){
            document.getElementById("lista_pedidos").innerHTML=""
        }else{
            let formulario = new FormData();
            let email
            if (localStorage.getItem("usuario")) {
                email = localStorage.getItem("usuario")
            } else if (sessionStorage.getItem("usuario")){
                email = sessionStorage.getItem("usuario")
            }
            formulario.append("email", email);
     
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/usuario_pedidos.php");
            xhr.addEventListener("load", (respuesta) => {
                let json = JSON.parse(respuesta.target.response)
                //pintar datos
                let tabla = document.createElement("table")
                tabla.innerHTML = '<tr><th>Id pedido</th><th>Precio</th><th>Fecha</th><th colspan="3"></th></tr>'
                let propiedades = ["id_compra", "precio", "fecha"]
                let acciones = ["link_detalles", "link_habrir_incidencia", "link_devolver_pedido"]
                tabla.setAttribute("id", "tabla_pedidos")
                let eventos = [];

                console.log(eventos.length)
                //lo que hago aquie es recorrer el arry al reves para pintar al principio de la tabla las consultas mas recientes
                for (let i = json.length-1; i >= 0; i--) {
                    let tr = document.createElement("tr")
                    tr.setAttribute("id", "fila_pedido;"+(i-(json.length-1)))
                    //para evitar un codigo mas largo tengo las keys de las posiciones en el array propiedades y asi voy sacandolas en cada fila
                    for (let j = 0; j < Object.keys(json[i]).length; j++) {
                        let td = document.createElement("td")
                        td.setAttribute("id", propiedades[j]+";"+((json.length-1)-i))
                        td.innerHTML = json[i][propiedades[j]]
                        tr.appendChild(td)
                    }
                    
                    let contenido = ["Detalles", "Habrir incidencia", "Devolver pedido"]
                    for (let j = 0; j < acciones.length; j++) {
                        let td2 = document.createElement("td")
                        td2.setAttribute("id", acciones[j]+";"+((json.length-1)-i))
                        let a = document.createElement("a");
                        a.setAttribute("href","")
                        a.setAttribute("id", acciones[j]+";"+((json.length-1)-i))
                        a.innerHTML = contenido[j];
                        td2.appendChild(a)
                        tr.appendChild(td2)
                    }
                    tabla.appendChild(tr)
                }
                document.getElementById("lista_pedidos").appendChild(tabla)
                
                //existir
                for (let i= 0; i < json.length; i++) {
                    for (let j = 0; j < acciones.length; j++) {
                        document.getElementById("link_detalles;"+i).addEventListener("click", detallesPedido);
                        document.getElementById("link_habrir_incidencia;"+i).addEventListener("click", habrirIncidencia);
                        document.getElementById("link_devolver_pedido;"+i).addEventListener("click", devolverPedido);
                    }
                }
            });
            xhr.send(formulario)
        }
    }

    function detallesPedido(e){
        e.preventDefault();
        let formulario = new FormData();
        let email = "";
        if (localStorage.getItem("usuario")) {
            email =  localStorage.getItem("usuario")
        } else if (sessionStorage.getItem("usuario")){
            email =  sessionStorage.getItem("usuario")
        }
        formulario.append("tipo", "cargar");
        formulario.append("email", email);

        //recogemos el numero pedido
        let pedido = document.getElementById("id_compra;"+this.id.split(";")[1]).innerText;
        formulario.append("id_pedido", pedido);
 
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/comprobar_pedido.php");
        xhr.addEventListener("load", (resultado) => {
            let respuesta = resultado.target.response
            if(respuesta.includes("bien")){
                pintarFactura(pedido)
            }
        });
        xhr.send(formulario);
    }
    
    function pintarFactura(pedido){
        let formulario = new FormData();
        formulario.append("id_pedido", pedido);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/pintar_factura_pedidos.php");
        xhr.addEventListener("load", (resultado) => {
            let respuesta = resultado.target.response
            document.getElementById("formulario_usuario").style.display = "none";
            document.getElementById("factura").style.display = "block";
            document.getElementById("factura").innerHTML = respuesta
        });
        xhr.send(formulario);

    }
    
    function habrirIncidencia(e){
        e.preventDefault();
        console.log(this.id)
    }
    function devolverPedido(e){
        e.preventDefault();
        console.log(this.id)
    }
    
}
