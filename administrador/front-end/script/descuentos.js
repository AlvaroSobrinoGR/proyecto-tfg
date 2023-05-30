window.addEventListener("load", funciones)

function funciones(){

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/obtener_descuentos.php");
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
        tabla.innerHTML += '<tr><th>id descuento</th><th>porcentaje</th><th>id producto</th></tr>'
        let propiedades = ["id_descuento", "porcentaje", "id_producto"]
        let descuentos = [];
            
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
            let td = document.createElement("td")
            let a = document.createElement("a")
            a.setAttribute("id", "eliminar;"+json[i]["id_descuento"])
            a.setAttribute("href", "")
            descuentos[i] = json[i]["id_descuento"];
            a.innerHTML = "eliminar"
            a.style.color = "blue"
            td.appendChild(a)
            tr.appendChild(td)
            tabla.appendChild(tr)
        }
        for (let index = 0; index < descuentos.length; index++) {
            document.getElementById("eliminar;"+descuentos[index]).addEventListener("click", eliminarDescuento)
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
        xhr.open("POST", "../back-end/busqueda_descuentos.php");
        xhr.addEventListener("load", (respuesta) => {
            if(!respuesta.target.response.includes("No hay resultados")){
                pintar(JSON.parse(respuesta.target.response))
            }else{
                alert(respuesta.target.response)
            }
        });
        xhr.send(formulario);
    }

    document.getElementById("añadirDescuento").addEventListener("click", añadirDescuento)

    function añadirDescuento(){

        let id_producto = evaluarIdProducto(parseFloat(document.getElementById("idprodcutoañadir").value))
        let porcentaje = evaluarDescuento(parseFloat(document.getElementById("porcentajeañadir").value))

        if(id_producto!=false && porcentaje!=false){
            let xhr = new XMLHttpRequest();
            let formulario = new FormData();
            formulario.append("tipo", "añadir");
            formulario.append("id_producto", id_producto);
            formulario.append("porcentaje", porcentaje);
            xhr.open("POST", "../back-end/operaciones_descuentos.php");
            xhr.addEventListener("load", (respuesta) => {
                alert(respuesta.target.response)
            });
            xhr.send(formulario);
        }
    }

    

    function evaluarDescuento(valor) {
        // Verificar si el valor es numérico, positivo y no mayor a 100
        if (typeof valor === 'number' && valor >= 0 && valor <= 100) {
          // Verificar si el valor es entero
          if (Number.isInteger(valor)) {
            return valor.toFixed(2); // Añadir ".00" a los valores enteros
          } else {
            // Redondear a dos decimales si hay más de dos
            let valorRedondeado = Math.round(valor * 100) / 100;
            // Convertir el valor redondeado a cadena con dos decimales
            let valorFormateado = valorRedondeado.toFixed(2);
            // Verificar si el valor formateado tiene un solo decimal
            if (valorFormateado.split('.')[1].length === 1) {
              return valorFormateado + '0'; // Añadir un "0" al final si falta un decimal
            } else {
              return valorFormateado; // Devolver el valor formateado sin modificaciones
            }
          }
        } else {
          // Mostrar alerta en caso de valor no válido
          alert('El valor del porcentaje debe ser numérico, positivo y no mayor a 100.00');
          return false;
        }
      }

      function evaluarIdProducto(valor) {
        if (typeof valor === 'number' && Number.isInteger(valor) && valor >= 0) {
            return valor;
        } else {
          alert('El id del producto no es numérico, no es entero o es negativo.');
          return false;
        }
      }

      function eliminarDescuento(e){
        e.preventDefault();
        let confirmacion = confirm("¿Estás seguro de que deseas eliminar este descuento con id descuento: "+this.id.split(";")[1]+"?");

        if (confirmacion) {
          let xhr = new XMLHttpRequest();
          let formulario = new FormData();
          formulario.append("tipo", "eliminar");
          formulario.append("id_descuento", this.id.split(";")[1]);
          xhr.open("POST", "../back-end/operaciones_descuentos.php");
          xhr.addEventListener("load", (respuesta) => {
            alert(respuesta.target.response);
          });
          xhr.send(formulario);
        } else {
          // Acción a realizar si el cliente cancela
          console.log("Eliminación cancelada por el cliente.");
        }
    }

    document.getElementById("avisarDescuento").addEventListener("click", avisarDescuento)

    function avisarDescuento(){

        if(document.getElementById("iddescuentoaviso").value.length>0){
            let xhr = new XMLHttpRequest();
            let formulario = new FormData();
            formulario.append("tipo", "avisar");
            formulario.append("id_descuento", document.getElementById("iddescuentoaviso").value);
            xhr.open("POST", "../back-end/operaciones_descuentos.php");
            xhr.addEventListener("load", (respuesta) => {
                alert(respuesta.target.response)
            });
            xhr.send(formulario);
        }else{
          alert("Debes introducir un id de descuento")
        }
    }


}