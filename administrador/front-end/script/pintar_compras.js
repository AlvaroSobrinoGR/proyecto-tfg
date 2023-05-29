window.addEventListener("load", funciones)

function funciones(){

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/obtener_compras.php");
    xhr.addEventListener("load", (respuesta) => {
        
        console.log(JSON.parse(respuesta.target.response))
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
         for (let i = 0 ; i < json.length; i++) {
            tabla.innerHTML += '<tr><th>Id compra</th><th>Id usuario</th><th>Id datos comprador</th><th>Tiempo local compra</th><th>Zulu time compra</th><th>Id orden compra</th><th>Id pagador</th><th>Email pagador</th><th>Nombre apellido pagador</th><th>Precio total</th><th>Id cupon</th><th>Total tras codigo</th><th>Porcentaje IVA</th><th>Total final con IVA</th></tr>'
            tabla.innerHTML +="<tr><td>"+json[i]["id_compra"]+"</td><td>"+json[i]["id_usuario"]+"</td><td>"+json[i]["id_datos_comprador"]+"</td><td>"+json[i]["tiempo_local_compra"]+"</td><td>"+json[i]["zulu_time_compra"]+"</td><td>"+json[i]["id_orden_compra"]+"</td><td>"+json[i]["id_pagador"]+"</td><td>"+json[i]["email_pagador"]+"</td><td>"+json[i]["nombre_apellido_pagador"]+"</td><td>"+json[i]["precio_total"]+"</td><td>"+json[i]["id_cupon"]+"</td><td>"+json[i]["total_tras_codigo"]+"</td><td>"+json[i]["porcentaje_iva"]+"</td><td>"+json[i]["total_final_con_iva"]+"</td></tr>"
            tabla.innerHTML += '<tr><td colspan=\"8\"></td><th>id_producto</th><th>cantidad</th><th>precio_unidad</th><th>precio_total_prodcuto</th><th>porcentaje_descuento</th><th>total_tras_descuento</th></tr>'
            for(let j = 0; j < Object.keys(json[i]["productos"]).length; j++){
                tabla.innerHTML +="<td colspan=\"8\"></td></td><td>"+json[i]["productos"][j]["id_producto"]+"</td><td>"+json[i]["productos"][j]["cantidad"]+"</td><td>"+json[i]["productos"][j]["precio_unidad"]+"</td><td>"+json[i]["productos"][j]["precio_total"]+"</td><td>"+json[i]["productos"][j]["porcentaje_descuento"]+"</td><td>"+json[i]["productos"][j]["total_tras_descuento"]+"</td></tr>"
            }
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
        xhr.open("POST", "../back-end/busqueda_compras.php");
        xhr.addEventListener("load", (respuesta) => {
            console.log(respuesta.target.response)
            if(!respuesta.target.response.includes("No hay resultados")){
                pintar(JSON.parse(respuesta.target.response))
            }else{
                alert(respuesta.target.response)
            }
        });
        xhr.send(formulario);
    }




}