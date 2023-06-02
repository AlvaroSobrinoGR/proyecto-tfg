window.addEventListener("load", funciones)

function funciones(){
    let formulario = new FormData();
    let queryParams = new URLSearchParams(window.location.search);

    if(queryParams.get('id_producto')!=null){
        let id_producto = queryParams.get('id_producto');
        formulario.append("id_producto", id_producto);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../back-end/pagina_producto.php");
        xhr.addEventListener("load", (respuesta) => {
            if(respuesta.target.response.includes("Algo ha fallado. Inténtelo de nuevo más tarde.")){
                alert(respuesta.target.response);
                window.location.href = "../../../index.html"
            }else if(respuesta.target.response.includes("no activo")){
                window.location.href = "../../../index.html"
            }else {
                let json = JSON.parse(respuesta.target.response)
                if(json[0]["stock"]==1){//comprar
                    let comprar = document.createElement("input")
                    comprar.setAttribute("type", "button")
                    comprar.setAttribute("id", "comprar_producto;"+id_producto)
                    comprar.setAttribute("value", "Añadir a la cesta")

                    if(!saber_si_hay_usuario()){
                        comprar.setAttribute("title", "Debes iniciar sesion para poder añadir este producto a tu carro")
                        comprar.setAttribute("class", "comprar_boton_bloqueado");
                    }else{
                        comprar.setAttribute("title", "Añadir este producto al carro")
                        comprar.setAttribute("class", "comprar_boton");
                    }

                    document.getElementById("accionPaginaProducto").appendChild(comprar)
                    if(saber_si_hay_usuario()){
                        document.getElementById("comprar_producto;"+id_producto).addEventListener("click", comprarProducto);
                    }
                    
                    
                    if(json[0]["descuento"]>0){
                        document.getElementById("nomrePrecioProducto").innerHTML = "<del>"+Number(json[0]["precio"]).toLocaleString("es-ES",{minimumFractionDigits: 2, maximumFractionDigits:2})+"</del>&euro;"+" -"+json[0]["descuento"]+"%"+" &#8594; "+Number(json[0]["precio_con_descuento"]).toLocaleString("es-ES",{minimumFractionDigits: 2, maximumFractionDigits:2, style:"currency", currency:"EUR"});
                    }else{
                        document.getElementById("nomrePrecioProducto").innerHTML  = Number(json[0]["precio"]).toLocaleString("es-ES",{minimumFractionDigits: 2, maximumFractionDigits:2, style:"currency", currency:"EUR"});
                    }
                }else if(json[0]["stock"]==0){
                    let avisar = document.createElement("input")
                    avisar.setAttribute("type", "button")
                    avisar.setAttribute("id", "avisar_producto;"+id_producto)
                    avisar.setAttribute("value", "Avisarme")

                    if(!saber_si_hay_usuario()){
                        avisar.setAttribute("title", "Debes iniciar sesion para poder avisarte cuando este producto vuelva a estar disponible")
                        avisar.setAttribute("class", "avisar_boton_bloqueado");
                    }else{
                        avisar.setAttribute("title", "Te avisaremos por email cuando este producto vuelva a estar disponible")
                        avisar.setAttribute("class", "avisar_boton");
                    }

                    document.getElementById("accionPaginaProducto").appendChild(avisar)
                    if(saber_si_hay_usuario()){
                        document.getElementById("avisar_producto;"+id_producto).addEventListener("click", avisarProducto);
                    }
                    
    
                    if(json[0]["descuento"]>0){
                        document.getElementById("nomrePrecioProducto").innerHTML  = "<del>"+Number(json[0]["precio"]).toLocaleString("es-ES",{minimumFractionDigits: 2, maximumFractionDigits:2})+"</del>&euro;"+" -"+json[0]["descuento"]+"%"+" &#8594; "+Number(json[0]["precio_con_descuento"]).toLocaleString("es-ES",{minimumFractionDigits: 2, maximumFractionDigits:2, style:"currency", currency:"EUR"});
                    }else{
                        document.getElementById("nomrePrecioProducto").innerHTML  = Number(json[0]["precio"]).toLocaleString("es-ES",{minimumFractionDigits: 2, maximumFractionDigits:2, style:"currency", currency:"EUR"});
                    }
                }
            }
        });
        xhr.send(formulario);      
    }else{
        document.getElementsByTagName("body")[0].innerHTML = ""
        alert("Algo ha fallado. Inténte entrar a la pagina más tarde.")
        window.location.href = "../../../index.html"
    }

    function comprarProducto(){
        if(sessionStorage.getItem("carrito_tienda_minimalista")){
            if(!sessionStorage.getItem("carrito_tienda_minimalista").includes(";"+this.id.split(";")[1]+";")){
                sessionStorage.setItem("carrito_tienda_minimalista", sessionStorage.getItem("carrito_tienda_minimalista")+this.id.split(";")[1]+";")
            }
        }else{
            sessionStorage.setItem("carrito_tienda_minimalista", ";"+this.id.split(";")[1]+";")
        }
        pintarNumeroProductos()
    }

    function avisarProducto(){
        let xhr = new XMLHttpRequest();
        let formulario = new FormData();
        formulario.append("id_producto", this.id.split(";")[1]);
        formulario.append("email", obtener_usuario());
        xhr.open("POST", "../../../back-end/aviso.php");
        xhr.addEventListener("load", (respuesta) => {
            alert(respuesta.target.response);
        });
        xhr.send(formulario);
    }
}