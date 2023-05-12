window.addEventListener("load", funciones)

function funciones() {

    //cesta1
    let numeroProductos = 1;
    //carrito
    if(sessionStorage.getItem("carrito")){
        document.getElementById("siguiente1").style.display = "block";
       pedirProductos(sessionStorage.getItem("carrito"))
    }


    function pedirProductos(carrito){
        let formulario = new FormData();
        formulario.append("carrito", carrito)
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/carrito.php");
        xhr.addEventListener("load", (respuesta) => {//recojo el json que pinto en php
            let json = JSON.parse(respuesta.target.response)
            numeroProductos = json.length;
            pintarProductos(json)
            calculos()
        });
        xhr.send(formulario);

    }

    function pintarProductos(productos){
        for (let i = 0; i < productos.length; i++) {
            let tr = document.createElement("tr");
            tr.setAttribute("id", "fila_producto;"+i)
            let td = document.createElement("td");
            //cantidad
            td.setAttribute("id", "cantidad;"+productos[i]["id_producto"])
            if(productos[i]["stock"]==1){
                let input = document.createElement("input");
                input.setAttribute("id", "unidades;"+productos[i]["id_producto"])
                input.setAttribute("type", "number")
                input.setAttribute("min", 1)
                input.setAttribute("max", 20)
                input.setAttribute("value", 1)
                input.setAttribute("onkeypress", "return false;")
                td.appendChild(input);
            }else{
                let p = document.createElement("p");
                p.setAttribute("id", "unidades;"+productos[i]["id_producto"])
                p.innerText = "ya no quedan unidades"
                td.appendChild(p);
            }
            tr.appendChild(td);
            //producto
            td = document.createElement("td");
            td.setAttribute("id", "producto;"+productos[i]["id_producto"])
            let img = document.createElement("img")
            let nombre = document.createElement("h4")
            img.setAttribute("id", "imagen;"+productos[i]["id_producto"])
            img.setAttribute("src", "img_productos/"+productos[i]["id_producto"]+".jpg")
            img.setAttribute("width", "80");
            img.setAttribute("height", "80");
            nombre.setAttribute("id", "nombre;"+productos[i]["id_producto"])
            nombre.innerHTML = productos[i]["nombre"];
            td.appendChild(img);
            td.appendChild(nombre);
            tr.appendChild(td);
            //precio
            td = document.createElement("td");
            td.setAttribute("id", "precio;"+productos[i]["id_producto"])

            if(productos[i]["descuento"]>0){
                td.innerHTML = "<del>"+productos[i]["precio"]+"</del>"+" "+productos[i]["descuento"]+"%"+" --> "+productos[i]["precio_con_descuento"];
            }else{
                td.innerHTML = productos[i]["precio"]
            }
            

            tr.appendChild(td);
            //precio total
            td = document.createElement("td");
            td.setAttribute("id", "precioTotal;"+productos[i]["id_producto"])

            if(productos[i]["descuento"]>0){
                td.innerHTML = productos[i]["precio_con_descuento"];
            }else{
                td.innerHTML = productos[i]["precio"]
            }

            tr.appendChild(td);
            //eliminar
            td = document.createElement("td");
            td.setAttribute("id", "eliminar;"+productos[i]["id_producto"])
            let a = document.createElement("a")
            a.setAttribute("id", "liminarProducto;"+i+";"+productos[i]["id_producto"])
            a.setAttribute("href", "")
            a.innerText = "eliminar"
            td.appendChild(a);
            tr.appendChild(td);
            document.getElementById("cestaCompra").getElementsByTagName("tbody")[0].appendChild(tr); 
        
        }
        let contenidoFinal = `<tr id="pieSumaSinIva">
                                <td colspan="3">Total sin iva:</td>
                                <td id="sumaSinIva"></td>
                                <td></td>
                            </tr>
                            <tr id="piecupon">
                                <td colspan="2">Aplicar codigo descuento:</td>
                                <td id="tdcupon">
                                    <input type="text" id="codigoDescuento"><br>
                                    <span id="errorCupon"></span>
                                </td>
                                <td id="porcentajeCupon"></td>
                                <td></td>
                            </tr>
                            <tr id="piecupon2">
                                <td colspan="3">Tras codigo descuento:</td>
                                <td id="precioCupon"></td>
                                <td ></td>
                            </tr>
                            <tr id="pieiva">
                                <td colspan="3">IVA 21%:</td>
                                <td id="iva"></td>
                                <td></td>
                            </tr>
                            <tr id="pieTotalMasIva">
                                <td colspan="3">Total con IVA:</td>
                                <td id="totalMasIva"></td>
                                <td></td>
                            </tr>`
        document.getElementById("cestaCompra").getElementsByTagName("tbody")[0].innerHTML+=contenidoFinal

        for (let i = 0; i < productos.length; i++) {
            document.getElementById("unidades;"+productos[i]["id_producto"]).addEventListener("change", precioUnidad)
            document.getElementById("liminarProducto;"+i+";"+productos[i]["id_producto"]).addEventListener("click", eliminarProducto)
        }
        document.getElementById("codigoDescuento").addEventListener("change", ponerCodigoDescuento)
        
    }

    function eliminarProducto(e){
        e.preventDefault();
        //aliminamos de pagina
        let fila = this.id.split(";")[1]
        document.getElementById("fila_producto;"+fila).remove()
        //alimnamos de sesion carrrito
        let producto = this.id.split(";")[2]
        let carrito = sessionStorage.getItem("carrito").split(";");
        carrito = carrito.slice(1,carrito.length-1)
        if(carrito.length==1){
            sessionStorage.removeItem("carrito")
            document.getElementById("siguiente1").style.display = "none";
        }else{
            numeros = carrito.filter(numero => numero !== producto);
            sessionStorage.setItem("carrito", ";"+numeros.join(";")+";")
        }
        calculos()
    }

    function precioUnidad(){
        let idproducto = this.id.split(";")[1]
        let unidades = document.getElementById(this.id).value
        let precioUnitario = document.getElementById("precio;"+idproducto).innerText; 
        if(precioUnitario.length>6){
            precioUnitario = precioUnitario.split('-->');
            precioUnitario = parseFloat(precioUnitario[1].trim());
        }
        precioUnitario = parseFloat(precioUnitario)
        document.getElementById("precioTotal;"+idproducto).innerText = (unidades*precioUnitario).toFixed(2)
        calculos()
    }

    function calculos(){
        let precioTotal = 0;
        for (let i = 0; i < numeroProductos; i++) {
            if(document.getElementById("fila_producto;"+i)){
                precioTotal += parseFloat(document.getElementById("fila_producto;"+i).getElementsByTagName("td")[3].innerText)
            }
        }
        document.getElementById("sumaSinIva").innerHTML=precioTotal.toFixed(2)
        

        if(document.getElementById("porcentajeCupon").innerText.length>0){
            let contenido = document.getElementById("porcentajeCupon").innerText;
            contenido = contenido.substring(1,contenido.length-2);
            if(!isNaN(parseFloat(contenido).toFixed(2))){
                document.getElementById("precioCupon").innerHTML=(precioTotal.toFixed(2)-(precioTotal.toFixed(2)*parseFloat(contenido)/100)).toFixed(2);
                precioTotal = (precioTotal.toFixed(2)-(precioTotal.toFixed(2)*parseFloat(contenido)/100)).toFixed(2);
            }else{
                document.getElementById("precioCupon").innerHTML=precioTotal.toFixed(2)
            }
        }else{
            document.getElementById("precioCupon").innerHTML=precioTotal.toFixed(2)
        }

        document.getElementById("iva").innerHTML=(precioTotal*21/100).toFixed(2)
        document.getElementById("totalMasIva").innerHTML=parseFloat((parseFloat(precioTotal*21/100))+parseFloat(precioTotal)).toFixed(2)
    }

    function ponerCodigoDescuento(){
        let formulario = new FormData();
        formulario.append("codigoDescuento", document.getElementById("codigoDescuento").value)
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/carrito_codigo.php");
        xhr.addEventListener("load", (respuesta) => {//recojo el json que pinto en php
            let resultado = respuesta.target.response;
            if(resultado!="el codigo esta desabilitado" && resultado!="el codigo no existe"){
                document.getElementById("porcentajeCupon").innerHTML = "-"+resultado+"%"
                document.getElementById("errorCupon").innerHTML = ""
            }else{
                document.getElementById("porcentajeCupon").innerHTML = ""
                document.getElementById("errorCupon").innerHTML = resultado
                document.getElementById("errorCupon").style.color = "red"
            }
            calculos()
        });
        xhr.send(formulario);
    }

    //cesta2
    document.getElementById("siguiente1").addEventListener("click", moverse)
    document.getElementById("siguiente2").addEventListener("click", moverse)
    document.getElementById("atras1").addEventListener("click", moverse)
    document.getElementById("atras2").addEventListener("click", moverse)

    function moverse(e){
        e.preventDefault()
        if(this.id=="siguiente1"){
            comprobarStock("siguiente1")
        }else if(this.id=="atras1"){
            document.getElementById("cesta1").style.display="block"
            document.getElementById("cesta2").style.display="none"
        }else if(this.id=="siguiente2"){
            comprobarStock("siguiente2")
        }else if(this.id=="atras2"){
            document.getElementById("cesta2").style.display="block"
            document.getElementById("cesta3").style.display="none"
        }
        
    }

//datos del usuario
    //mostrar datos usuario
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
            let json = JSON.parse(respuesta)
            document.getElementById("nombre").value = json[0]["nombre"]
            document.getElementById("direccion").value = json[0]["direccion"]
            document.getElementById("telefono").value = json[0]["telefono"]
            comprobacion()
        });
        xhr.send(formulario);
    }
    //cambios en los inputs
    document.getElementById("nombre").addEventListener("input", comprobacion)
    document.getElementById("direccion").addEventListener("input", comprobacion)
    document.getElementById("telefono").addEventListener("input", comprobacion)

    function comprobacion(){ //ahi que implementar patrones
        if(document.getElementById("nombre").value.length>0 && document.getElementById("direccion").value.length>0 && document.getElementById("telefono").value.length>0){
            document.getElementById("siguiente2").style.display = "block";
            document.getElementById("siguiente2").addEventListener("click", conexionGuardar)
        }else{
            document.getElementById("siguiente2").style.display = "none";
        }
    }

    //enviar informacion del formulario usuario

    function conexionGuardar(e) {
    e.preventDefault()
    let formulario = new FormData();
    let email = "";

    if (localStorage.getItem("usuario")) {
        email =  localStorage.getItem("usuario")
    } else if (sessionStorage.getItem("usuario")){
        email =  sessionStorage.getItem("usuario")
    }
    formulario.append("tipo", "configuracionCarrito");
    formulario.append("email", email);
    formulario.append("nombre", document.getElementById("nombre").value);
    formulario.append("direccion", document.getElementById("direccion").value);
    formulario.append("telefono", document.getElementById("telefono").value);


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/configuracion_usuario.php");
    xhr.addEventListener("load", (resultado) => {
        let respuesta = resultado.target.response

        console.log(respuesta)

    });
    xhr.send(formulario);
    }


    function comprobarStock(tipo){
        let formulario = new FormData();
        let productos_cantidades = ";"
        let tr = document.getElementById("cestaCompra").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        let cantidad_productos = tr.length-4
        for (let index = 1; index < cantidad_productos+1; index++) {
            let numero_producto = tr[index].getElementsByTagName("td")[0].id.split(";")[1]
            productos_cantidades+=numero_producto+"-";
            if(document.getElementById("unidades;"+numero_producto)!=null){
                productos_cantidades+= document.getElementById("unidades;"+numero_producto).value+";"
            }
        }
        formulario.append("productos_cantidades", productos_cantidades)
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/compraStock.php");
        xhr.addEventListener("load", (resultado) => {
            if(resultado.target.response.length>0){
                if(tipo=="siguiente2"){
                    document.getElementById("cesta2").style.display="none"
                    document.getElementById("cesta1").style.display="block"
                }
                alert(resultado.target.response)
                if(resultado.target.response.includes("agotado")){
                    document.getElementById("cestaCompra").getElementsByTagName("tbody")[0].innerHTML=""
                    document.getElementById("cestaCompra").getElementsByTagName("tbody")[0].innerHTML='<tr id="cabecera">' +
                    '<td>Cantidad</td>' +
                    '<td>Producto</td>' +
                    '<td>Precio unitario</td>' +
                    '<td>Precio Total</td>' +
                    '<td></td>' +
                '</tr>'
                    pedirProductos(sessionStorage.getItem("carrito"))
                }
            }else if(tipo=="siguiente1"){
                document.getElementById("cesta1").style.display="none"
                document.getElementById("cesta2").style.display="block"
                conexionCargar()
            }else if (tipo=="siguiente2"){
                document.getElementById("cesta2").style.display="none"
                document.getElementById("cesta3").style.display="block"
            }
        });
        xhr.send(formulario);
    }
        
        
        
        /*
        1-cuando llegue al carrito que se forme una tabla con las cosas compradas y opciones
            1-a medida vaya modificando estos valores tiene que ir viendose como va saliendo el pago
        2-saldran los campos de los datos del usuario, cuando pase a la siguiente pagina estos datos se guardaran en la base de datos
        3-hacer el pago con targeta
        4-confirmar que sel pago con targeta se hizo y todos los demas procesos de back
    */

}