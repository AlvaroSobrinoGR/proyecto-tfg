window.addEventListener("load", funciones)

function funciones(){

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/obtener_incidencias.php");
    xhr.addEventListener("load", (respuesta) => {
        
        console.log(respuesta.responseText);
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
        tabla.innerHTML += '<tr><th>id_incidencia</th><th>id_empleado</th><th>id_compra</th><th>asunto</th><th>consulta</th><th>estado</th><th>fecha</th></tr>'
        let propiedades = ["id_incidencia","id_empleado", "id_compra","asunto", "consulta", "estado", "fecha"]

        //lo que hago aquie es recorrer el arry al reves para pintar al principio de la tabla las incidencias mas recientes
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
        xhr.open("POST", "../back-end/busqueda_incidencias.php");
        xhr.addEventListener("load", (respuesta) => {
            if(!respuesta.target.response.includes("No hay resultados")){
                pintar(JSON.parse(respuesta.target.response))
            }else{
                alert(respuesta.target.response)
            }
        });
        xhr.send(formulario);
    }

    document.getElementById("cargoIncidencia").addEventListener("click", cargoIncidencia)

    function cargoIncidencia(){

        let id_empleado = parseInt(document.getElementById("IDEmpleado").innerText)
        let id_incidencia = parseInt(document.getElementById("idincidenciacargo").value)
        

        if(id_incidencia >= 0 && id_empleado >= 0){
            if(id_empleado ==0){
                id_empleado= "Z";
            }
            if(id_incidencia ==0){
                id_incidencia= "Z";
            }
            let xhr = new XMLHttpRequest();
            let formulario = new FormData();
            formulario.append("tipo", "cargoIncidencia");
            formulario.append("id_empleado", id_empleado);
            formulario.append("id_incidencia", id_incidencia);
            xhr.open("POST", "../back-end/operaciones_incidencias.php");
            xhr.addEventListener("load", (respuesta) => {
                alert(respuesta.target.response)
            });
            xhr.send(formulario);
        }else{
            alert("debes introducir en id de incidencia")
        }
    }

    document.getElementById("modifiaIncidencia").addEventListener("click", modifiaIncidencia)

    function modifiaIncidencia(){

        let id_empleado = parseInt(document.getElementById("IDEmpleado").innerText)
        let id_incidencia = parseInt(document.getElementById("idcincidenciamodificar").value)
        let estado = valorarEstado(document.getElementById("estadoIncidencia").value)

        if(id_incidencia >= 0 && id_empleado >= 0 && estado!=false){
            if(id_empleado ==0){
                id_empleado= "Z";
            }
            if(id_incidencia ==0){
                id_incidencia= "Z";
            }
            let xhr = new XMLHttpRequest();
            let formulario = new FormData();
            formulario.append("tipo", "modifiaIncidencia");
            formulario.append("id_empleado", id_empleado);
            formulario.append("id_incidencia", id_incidencia);
            formulario.append("estado", estado);
            xhr.open("POST", "../back-end/operaciones_incidencias.php");
            xhr.addEventListener("load", (respuesta) => {
                alert(respuesta.target.response)
            });
            xhr.send(formulario);
        }else{
            alert("debes introducir en id de incidencia y el estado en el que estara")
        }
    }

    function valorarEstado(valor){
        if (valor === "espera" || valor === "trabajando" || valor === "finalizada") {
            return valor
          } else {
            return false;
          }
    }

    
}