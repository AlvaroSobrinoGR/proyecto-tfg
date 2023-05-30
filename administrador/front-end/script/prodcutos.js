window.addEventListener("load", funciones)

function funciones(){

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/obtener_productos.php");
    xhr.addEventListener("load", (respuesta) => {
        
        console.log(respuesta)
        if(respuesta.target.response.length > 0){
            pintar(JSON.parse(respuesta.target.response))
        }else{
            alert("Algo ha saldio mal")
        }
    });
    xhr.send();

    function pintar(json){
        let tabla = document.getElementById("datos")
        tabla.innerHTML = "";
        tabla.innerHTML += '<tr><th>id producto</th><th>nombre</th><th>descripcion</th><th>tipo</th><th>stock</th><th>precio</th><th>estado</th></tr>'
        let propiedades = ["id_producto", "nombre", "descripcion", "tipo", "stock", "precio", "activo"]
            
        //lo que hago aquie es recorrer el arry al reves para pintar al principio de la tabla las consultas mas recientes
        for (let i = 0 ; i < json.length; i++) {
            let tr = document.createElement("tr")
            tr.setAttribute("id", "fila_usuarios;"+i)
            //para evitar un codigo mas largo tengo las keys de las posiciones en el array propiedades y asi voy sacandolas en cada fila
            for (let j = 0; j < Object.keys(json[i]).length; j++) {
                let td = document.createElement("td")
                td.setAttribute("id", propiedades[j]+";"+i)
                td.innerHTML = json[i][propiedades[j]]
                tr.appendChild(td)
            }
            tabla.appendChild(tr)
        }
    }
    document.getElementById("aplicar").addEventListener("click", aplicarBusqueda)

    function aplicarBusqueda(){
        let xhr = new XMLHttpRequest();
        let formulario = new FormData();
        formulario.append("buscar_por", document.getElementById("tipoBusqueda").value);
        formulario.append("contenido_busqueda", document.getElementById("contenidoBusqueda").value);
        formulario.append("orden", document.getElementById("orden").value);
        formulario.append("tipo_orden", document.getElementById("tipo_orden").value);
        xhr.open("POST", "../back-end/busqueda_productos.php");
        xhr.addEventListener("load", (respuesta) => {
            if(!respuesta.target.response.includes("No hay resultados")){
                pintar(JSON.parse(respuesta.target.response))
            }else{
                alert(respuesta.target.response)
            }
        });
        xhr.send(formulario);
    }
    
    document.getElementById("modificarStock").addEventListener("click", modificarStock)

    function modificarStock(){

        let id_producto = document.getElementById("idprodcutomodificar").value
        let stock = evaluarStock(parseFloat(document.getElementById("stockmodificar").value))
        if(stock!=false && id_producto.length > 0){
            let xhr = new XMLHttpRequest();
            let formulario = new FormData();
            formulario.append("tipo", "modificarStock");
            formulario.append("id_producto", id_producto);
            formulario.append("stock", stock);
            xhr.open("POST", "../back-end/operaciones_productos.php");
            xhr.addEventListener("load", (respuesta) => {
                alert(respuesta.target.response)
            });
            xhr.send(formulario);
        }else{
            alert("debes introducir en id de producto y una cantidad de stock")
        }
    }

    function evaluarStock(numero) {
        // Verificar si el número es un entero y es mayor que 0
        if (Number.isInteger(numero) && numero >=0) {
            if(numero ==0){
                return "Z";
            }
            return numero;
        } else {
            alert("el dtock debe ser un numero positivo entero mayor o igual a 0")
          return false;
          
        }
      }

    function evaluarStock(numero) {
        // Verificar si el número es un entero y es mayor que 0
        if (Number.isInteger(numero) && numero >=0) {
            if(numero ==0){
                return "Z";
            }
            return numero;
        } else {
            alert("el dtock debe ser un numero positivo entero mayor o igual a 0")
          return false;
          
        }
      }

      function evaluarStock(numero) {
        // Verificar si el número es un entero y es mayor que 0
        if (Number.isInteger(numero) && numero >=0) {
            if(numero ==0){
                return "Z";
            }
            return numero;
        } else {
            alert("el stock debe ser un numero positivo entero mayor o igual a 0")
          return false;
          
        }
      }

    document.getElementById("modificarEstado").addEventListener("click", modificarEstado)

    function modificarEstado(){

        let id_producto = document.getElementById("idprodcutoestado").value
        let activo = evaluarEstado(parseFloat(document.getElementById("estadomodificar").value))
        if(activo!=false && id_producto.length > 0){
            let xhr = new XMLHttpRequest();
            let formulario = new FormData();
            formulario.append("tipo", "modificarEstado");
            formulario.append("id_producto", id_producto);
            formulario.append("activo", activo);
            xhr.open("POST", "../back-end/operaciones_productos.php");
            xhr.addEventListener("load", (respuesta) => {
                alert(respuesta.target.response)
            });
            xhr.send(formulario);
        }else{
            alert("debes introducir en id de producto y un numero en estado")
        }
    }

    function evaluarEstado(numero) {
        // Verificar si el número es un entero y es mayor que 0
        if (numero ==1 || numero ==0) {
            if(numero ==0){
                return "Z";
            }
            return numero;
        } else {
            alert("el estado debe ser 1 (activo) 0 (inactivo)")
          return false;
          
        }
      }
      document.getElementById("avisarProducto").addEventListener("click", avisarProducto)
      function avisarProducto(){

        let id_producto = document.getElementById("iddescuentoaviso").value
        if(id_producto.length > 0){
            let xhr = new XMLHttpRequest();
            let formulario = new FormData();
            formulario.append("tipo", "avisarProducto");
            formulario.append("id_producto", id_producto);
            xhr.open("POST", "../back-end/operaciones_productos.php");
            xhr.addEventListener("load", (respuesta) => {
                alert(respuesta.target.response)
            });
            xhr.send(formulario);
        }else{
            alert("debes introducir en id de producto y un numero en estado")
        }
    }


    
}