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
            }else if(respuesta.target.response.includes("stock 1")){//comprar
                let comprar = document.createElement("input")
                comprar.style.backgroundColor="green"
                comprar.setAttribute("type", "button")
                comprar.setAttribute("id", "comprar_producto;"+id_producto)
                comprar.setAttribute("value", "Añadir a la cesta")
                document.getElementById("accionPaginaProducto").appendChild(comprar)
                document.getElementById("comprar_producto;"+id_producto).addEventListener("click", comprarProducto);
            }else if(respuesta.target.response.includes("stock 0")){
                let avisar = document.createElement("input")
                avisar.setAttribute("type", "button")
                avisar.setAttribute("id", "avisar_producto;"+id_producto)
                avisar.setAttribute("value", "Avisarme")
                avisar.style.backgroundColor="yellow"
                document.getElementById("accionPaginaProducto").appendChild(avisar)
                document.getElementById("avisar_producto;"+id_producto).addEventListener("click", avisarProducto);
            }
        });
        xhr.send(formulario);      
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