window.addEventListener("load", funciones)

function funciones (){
    //mostrar datos usuario
    conexionCargar()

    function conexionCargar() {
        let formulario = new FormData();
        formulario.append("tipo", "cargar");
        formulario.append("email", obtener_usuario());
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/configuracion_usuario.php");
        xhr.addEventListener("load", (resultado) => {
            let respuesta = resultado.target.response
            //pintar datos
            document.getElementById("email").innerHTML = obtener_usuario();
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
    let exito = true;
    if(this.id.includes("cambiarContraseña")){
        
        formulario.append("tipo", "contraseñia");
        formulario.append("email", obtener_usuario());
        document.getElementById("cambiarContraseña").disabled = true;

    }else if(this.id.includes("guardarCambios")){
        let patronNombreApellido = /^[A-ZÁÉÍÓÚÑ][a-zA-ZÁÉÍÓÚÑ]*(?:\s+[A-ZÁÉÍÓÚÑ][a-zA-ZÁÉÍÓÚÑ]*){1,}$/;
        let patronTelefono = /^\d{8}$/;
        let nombre = document.getElementById("nombre").value.trim();
        let telefono = document.getElementById("telefono").value.trim();
        if(!patronNombreApellido.test(nombre) && nombre.length>0){
            exito = false;
            document.getElementById("error_nombre").innerText = "Debes introducir almenos un nombre y un apellido como minimo, y deben empezar por mayuscula";
        }else{
            document.getElementById("error_nombre").innerText = "";
        }
        if(!patronTelefono.test(telefono) && telefono.length>0){
            exito = false;
            document.getElementById("error_telefono").innerText = "El telefono solo puede tener numeros y deben ser 8";
        }else{
            document.getElementById("error_telefono").innerText = "";
        }
        if(exito){
            formulario.append("tipo", "configuracion");
            formulario.append("email", obtener_usuario());
            formulario.append("nombre", nombre);

            formulario.append("direccion", document.getElementById("direccion").value);
            formulario.append("telefono", telefono);

            formulario.append("novedades", document.getElementsByName("novedades")[0].checked?1:0);
            document.getElementById("guardarCambios").disabled = true;
        }
        
        

    }
    if(exito){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/configuracion_usuario.php");
        xhr.addEventListener("load", (resultado) => {
            let respuesta = resultado.target.response
            alert(respuesta)
            document.getElementById("cambiarContraseña").disabled = false;
            document.getElementById("guardarCambios").disabled = false;
            
        });
        xhr.send(formulario);
    }
    }

    //cerrar sesion
    document.getElementById("cerrar_sesion").addEventListener("click", cerrarSesion)
    function cerrarSesion (e){
        e.preventDefault()
        if (saber_si_hay_usuario()) {
            eliminar_usuario()
        }
        window.location.href = "../index.html"
    }

    //consultas
    document.getElementById("consultas").addEventListener("click", listarConsultas)
    function listarConsultas(e){
        e.preventDefault()
        if(document.getElementById("lista_consultas").innerHTML.length>0){
            document.getElementById("lista_consultas").innerHTML=""
        }else{
            let formulario = new FormData();
            formulario.append("email", obtener_usuario());
     
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/usuario_consultas.php");
            xhr.addEventListener("load", (respuesta) => {
                if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                    alert(respuesta.target.response)
                }else{
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
                }
            });
            xhr.send(formulario)
        }
    }

    //incidencias
    document.getElementById("incidencias").addEventListener("click", listarIncidencias)
    function listarIncidencias(e){
        e.preventDefault()
        if(document.getElementById("lista_incidencias").innerHTML.length>0){
            document.getElementById("lista_incidencias").innerHTML=""
        }else{
            let formulario = new FormData();
            formulario.append("email", obtener_usuario());
     
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/usuario_incidencias.php");
            xhr.addEventListener("load", (respuesta) => {
                if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                    alert(respuesta.target.response)
                }else{
                    let json = JSON.parse(respuesta.target.response)
                    //pintar datos
                    tabla = document.createElement("table")
                    tabla.innerHTML = '<tr><th>Id incidencia</th><th>Id pedido</th><th>Asunto</th><th>Consulta</th><th>Estado</th><th>Fecha</th></tr>'
                    propiedades = ["id_incidencia","id_compra", "asunto", "consulta", "estado", "fecha"]
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
                    
                     document.getElementById("lista_incidencias").appendChild(tabla)
                }
                
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
            formulario.append("email", obtener_usuario());
     
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../back-end/usuario_pedidos.php");
            xhr.addEventListener("load", (respuesta) => {
                if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                    alert(respuesta.target.response)
                }else{
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
                            document.getElementById("link_habrir_incidencia;"+i).addEventListener("click", detallesPedido);
                            document.getElementById("link_devolver_pedido;"+i).addEventListener("click", detallesPedido);
                        }
                    }
                }
                
            });
            xhr.send(formulario)
        }
    }

    function detallesPedido(e){
        e.preventDefault();
        let formulario = new FormData();
        formulario.append("tipo", "cargar");
        formulario.append("email", obtener_usuario());

        //recogemos el numero pedido
        let pedido = document.getElementById("id_compra;"+this.id.split(";")[1]).innerText;
        formulario.append("id_pedido", pedido);
 
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/comprobar_pedido.php");
        xhr.addEventListener("load", (resultado) => {
            if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                alert(respuesta.target.response)
            }else{
                let respuesta = resultado.target.response
                if(respuesta.includes("bien")){
                    if(this.id.includes("link_detalles")){
                        pintarFactura(pedido)
                    }else if(this.id.includes("link_habrir_incidencia")){
                        habrirIncidencia(pedido)
                    }else if(this.id.includes("link_devolver_pedido")){
                        devolverPedido(pedido)
                    }
                }
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
            if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                alert(respuesta.target.response)
            }else{
                let respuesta = resultado.target.response
                document.getElementById("formulario_usuario").style.display = "none";
                document.getElementById("factura").style.display = "block";
                document.getElementById("factura_contenido").innerHTML = respuesta
            }
        });
        xhr.send(formulario);

    }

    document.getElementById("atras1").addEventListener("click", (e) => {
        e.preventDefault()
        document.getElementById("formulario_usuario").style.display = "block";
        document.getElementById("factura").style.display = "none";
        document.getElementById("factura_contenido").innerHTML = ""
    })

    document.getElementById("atras2").addEventListener("click", (e) => {
        e.preventDefault()
        document.getElementById("formulario_usuario").style.display = "block";
        document.getElementById("incidencia").style.display = "none";
    })

    document.getElementById("atras3").addEventListener("click", (e) => {
        e.preventDefault()
        document.getElementById("formulario_usuario").style.display = "block";
        document.getElementById("devolucion").style.display = "none";
    })
    
    function habrirIncidencia(pedido){
        let formulario = new FormData();
        formulario.append("id_pedido", pedido);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/pintar_factura_pedidos.php");
        xhr.addEventListener("load", (resultado) => {
            if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                alert(respuesta.target.response)
            }else{
                let respuesta = resultado.target.response
                document.getElementById("formulario_usuario").style.display = "none";
                document.getElementById("incidencia").style.display = "block";
                if(!document.getElementById("indicencia_id_pedido").value.includes(pedido)){

                    document.getElementById("indicencia_id_pedido").value = pedido;
                    document.getElementById("indicencia_asunto").value = "";
                    document.getElementById("indicencia_consulta").value = "";
                }
            }
        });
        xhr.send(formulario);
    }

    document.getElementById("enviar_incidencia").addEventListener("click", enviarIncidencia)
    function enviarIncidencia(){
        let formulario = new FormData();
        formulario.append("email", obtener_usuario())
        formulario.append("id_pedido", document.getElementById("indicencia_id_pedido").value)
        formulario.append("asunto", document.getElementById("indicencia_asunto").value)
        formulario.append("consulta", document.getElementById("indicencia_consulta").value)
        document.getElementById("enviar_incidencia").disabled = true;
        let fechaActual = new Date();
        let fechaActualFormateada = fechaActual.getFullYear() + '-' + (fechaActual.getMonth() + 1).toString().padStart(2, '0') + '-' + fechaActual.getDate().toString().padStart(2, '0') + ' ' + fechaActual.getHours().toString().padStart(2, '0') + ':' + fechaActual.getMinutes().toString().padStart(2, '0') + ':' + fechaActual.getSeconds().toString().padStart(2, '0');
        formulario.append("fecha", fechaActualFormateada)
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/incidencia.php")
        xhr.addEventListener("load", (respuesta)=>{
            alert(respuesta.target.response)
            document.getElementById("enviar_incidencia").disabled = false;
        })
        xhr.send(formulario);
    }

    function devolverPedido(pedido){
        let formulario = new FormData();
        formulario.append("id_pedido", pedido);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/usuario_devolucion_datos.php");
        xhr.addEventListener("load", (resultado) => {
            if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                alert(respuesta.target.response)
            }else{
                let json = JSON.parse(resultado.target.response)
                document.getElementById("formulario_usuario").style.display = "none";
                document.getElementById("devolucion").style.display = "block";
                pintarDevolucion(json)
            }
        });
        xhr.send(formulario);
    }

    function  pintarDevolucion(json){
        let tabla = document.createElement("table")
        tabla.setAttribute("id", "tabla_devoluciones")
        let tr = document.createElement("tr")
        let th = document.createElement("th")
        th.innerHTML = "Id compra: <span id=\"id_compra_devolucion\">"+json[0]["id_compra"]+"</span>"
        tr.appendChild(th)
        tabla.appendChild(tr)
        tr = document.createElement("tr")
        th1 = document.createElement("th")
        tr.appendChild(th1)//check
        let th2 = document.createElement("th")
        tr.appendChild(th2)//foto
        let th3 = document.createElement("th")
        th3.innerText = "Producto"
        tr.appendChild(th3)//nombre
        let th4 = document.createElement("th")
        th4.innerText = "Cantidad"
        tr.appendChild(th4)//cantidad
        tabla.appendChild(tr)
        for (let i = 1; i < json.length; i++) {
            let tr2 = document.createElement("tr")
            tr2.setAttribute("id", "fila_devoluciones;"+i)
            let td = document.createElement("td")
            //check
            let check = document.createElement("input")
            check.setAttribute("type", "checkbox")
            check.setAttribute("name", "checkbox_devolucones")
            check.setAttribute("id", "checkbox_dev;"+i)
            check.setAttribute("value", i+";"+json[i]["id_producto"])
            td.appendChild(check)
            tr2.appendChild(td)
            //imagen
            td = document.createElement("td")
            let img = document.createElement("img")
            img.setAttribute("src", "img_productos/"+json[i]["id_producto"]+".jpg")
            td.appendChild(img)
            tr2.appendChild(td)
            //nombre
            td = document.createElement("td")
            td.innerText = json[i]["nombre"];
            tr2.appendChild(td)
            //input
            td = document.createElement("td")
            let input = document.createElement("input")
            input.setAttribute("type", "number")
            input.setAttribute("min", "0")
            input.setAttribute("max", json[i]["cantidad"])
            input.setAttribute("value", "0")
            input.setAttribute("id", "cantidad_fila;"+i)
            input.setAttribute("disabled", true)
            td.appendChild(input)
            tr2.appendChild(td)
            tabla.appendChild(tr2)
        }
        tr = document.createElement("tr")
        let td = document.createElement("td")
        td.setAttribute("colspan", 4)
        let input = document.createElement("input")
        input.setAttribute("type", "button")
        input.setAttribute("id", "devolver_boton")
        input.setAttribute("value", "Devolver Productos")
        td.appendChild(input)
        tr.appendChild(td)
        tabla.appendChild(tr)
        document.getElementById("devolucion_contenido").innerHTML = ""
        document.getElementById("devolucion_contenido").appendChild(tabla)

        //existir
        for (let i = 0; i< json.length-1; i++) {
            document.getElementsByName("checkbox_devolucones")[i].addEventListener("input", activarFilaDevolucion)
        }
        document.getElementById("devolver_boton").addEventListener("click", devolverProductos)
    }

    //check validar el que ese producto se pueda devolver y elegir cantidad
    function activarFilaDevolucion(){
        let checkeds = document.getElementsByName("checkbox_devolucones")
        for(let i = 0; i< checkeds.length; i++){
            if(checkeds[i].checked){
                document.getElementById("cantidad_fila;"+checkeds[i].id.split(";")[1]).disabled = false;
            }else{
                document.getElementById("cantidad_fila;"+checkeds[i].id.split(";")[1]).disabled = true;
            }
        }
        
    }
    //si al menos un checkbox esta activo y tiene almenos un producto para devolver se podra devolver
    function devolverProductos(){
        let productos_cantidades = ";"
        let checkeds = document.getElementsByName("checkbox_devolucones")
        document.getElementById("devolver_boton").disabled = true;
        for(let i = 0; i< checkeds.length; i++){
            if(checkeds[i].checked){
                if(document.getElementById("cantidad_fila;"+checkeds[i].id.split(";")[1]).value>0){
                    productos_cantidades+=checkeds[i].value.split(";")[1]+"-"+document.getElementById("cantidad_fila;"+checkeds[i].id.split(";")[1]).value+";"
                }
            }
        }
        let formulario = new FormData();
        formulario.append("email", obtener_usuario());
        formulario.append("id_pedido_devolver", document.getElementById("id_compra_devolucion").innerText);
        formulario.append("productos_cantidades", productos_cantidades)       
        
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/usuario_devoluciones.php");
        xhr.addEventListener("load", (resultado) => {
            if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                alert(respuesta.target.response)
            }else{
                if(resultado.target.response.includes("devoluciohn realizada")){
                    alert("Devoluciohn realizada, le hemos mandado un email con la factura actualizada")
                    location.reload(true);
                }else{
                    alert(resultado.target.response)
                }
                document.getElementById("devolver_boton").disabled = false;
            }

            
        });
        xhr.send(formulario);
    }
}
