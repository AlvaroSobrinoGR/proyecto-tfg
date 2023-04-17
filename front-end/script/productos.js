window.addEventListener("load", funciones)

function funciones(){
    conexion(1)
    function conexion(numero_pagina){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/productos.php");
        xhr.addEventListener("load", (respuesta) => {
            let json = JSON.parse(respuesta.target.response)
            pintar(json, numero_pagina);
        });
        xhr.send();
    }
    function pintar(json, numero_pagina){
        document.getElementById("cuerpo").innerHTML="";
        for (let index = ((numero_pagina*4)-4); index < json.length && index < (numero_pagina*4); index++) {
            let div = document.createElement("div")
            let img = document.createElement("img")
            let h4 = document.createElement("h4")
            let p = document.createElement("p")
            img.setAttribute("src", "img_productos/"+json[index]["id_producto"]+".jpg")
            h4.innerHTML = json[index]["nombre"];
            p.innerHTML = json[index]["descripcion"];
            div.appendChild(img);
            div.appendChild(h4);
            div.appendChild(p);
            document.getElementById("cuerpo").appendChild(div)
        }
        let div = document.createElement("div");
        console.log(Math.ceil((json.length)/4))
        for (let index = 1; index < Math.ceil((json.length)/4)+1; index++) {
            let a = document.createElement("a")
            a.setAttribute("href", "#")
            a.setAttribute("id", "pagina;"+index)
            a.innerHTML=index;
            div.appendChild(a)
        }
        document.getElementById("cuerpo").appendChild(div)
        //existir
        for (let index = 1; index < Math.ceil((json.length+1)/4); index++) {
            document.getElementById("pagina;"+index).addEventListener("click", () =>{conexion(index);console.log(index)})
        }
    }
}