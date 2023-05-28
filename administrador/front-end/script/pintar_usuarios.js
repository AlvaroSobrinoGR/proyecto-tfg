window.addEventListener("load", funciones)

function funciones(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../back-end/obtener_usuarios.php");
    xhr.addEventListener("load", (respuesta) => {
        
        console.log(respuesta)
        if(respuesta.target.response.length > 0){
            let json = JSON.parse(respuesta.target.response)
             //pintar datos
             let tabla = document.getElementById("datos")
             tabla.innerHTML += '<tr><th>Id usuario</th><th>email</th><th>id_datos</th><th>nombre_apellido</th><th>direccion</th><th>telefono</th><th>validada</th></tr>'
             let propiedades = ["id_usuario", "email", "id_datos", "nombre_apellido", "direccion", "telefono", "validada"]
            
             
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


             
        }else{
            alert("algo ha saldio mal"+respuesta.target.response)
        }
    });
    xhr.send();




}