window.addEventListener("load", funciones)

function funciones(){

    conexion(1) //primero llamo una vez al metodo para que dibuje la primera pagina

    function conexion(numero_pagina){ //en esta funcion se hace la conexion
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/productos.php");
        xhr.addEventListener("load", (respuesta) => {//recojo el json que pinto en php
            let json = JSON.parse(respuesta.target.response)
            pintar(json, numero_pagina);//paso  a la funcion que se encarga de piuntar la lista de productos el json y la pagina en la que se encunrta el suario
        });
        xhr.send();
    }
    
    function pintar(json, numero_pagina){
        document.getElementById("cuerpo").innerHTML=""; //limpio siempre primero donde estan los productos, para que no se solapen las paginas
        let cantidad_producto = 4 //cantidad de productos por paginas
        for (let index = ((numero_pagina*cantidad_producto)-cantidad_producto); index < json.length && index < (numero_pagina*cantidad_producto); index++) {
        //el for funciona de la sigueinte forma:
            //el index empezara en la pagina que toca, multiplicado por cantidad_producto, que es el numero de elementos que quiero que haya por apgina, menos el mismo.
            //ejemplo: pagina 2 y cantidad_producto 4 --> (2*4)-4= 4, como lo que voy a recorrer es un array le estoy diciendo que empiece en la posicion 4, por tanto el producto 5
            //ya se pintaron los cuatro primeros productos en la pagina 1, ahora toca desde el quinto producto en la pagina 2

            //luego, la condicon: index < json.length && index < (numero_pagina*cantidad_producto)
            //la primera condicion es que el index sea menos al numero de productos que tiene el array, asi evitamos pasarnos, aunque quieras que sean ocmo maximo 4 productos por pagina quizas en la ultima solo sea 1 o 2
            //la segunda condicion es que el index sea menor al numero_pagina*cantidad_producto
                //ejemplo: pagina 2 y cantidad_producto 4 --> 2*4 = 8. si seguimos el ejemplo de la inicializacion del intex va desde el 4 hasta el 8. 4,5,6,7 --> producto: 5,6,7,8

            let div = document.createElement("div")
            let img = document.createElement("img")
            let h4 = document.createElement("h4")
            let p = document.createElement("p")
            let comprar = document.createElement("input")
            let avisar = document.createElement("input")

            if(json[index]["stock"]==0){
                avisar.setAttribute("type", "button")
                avisar.setAttribute("id", "avisar_producto;"+json[index]["id_producto"])
                avisar.setAttribute("value", "Avisar")
                avisar.style.backgroundColor="yellow"
            }else{
                comprar.style.backgroundColor="green"
                comprar.setAttribute("type", "button")
                comprar.setAttribute("id", "comprar_producto;"+json[index]["id_producto"])
                comprar.setAttribute("value", "Comprar")
            }

            //creo los elementos que ire añadiendo al cuerpo donde iran los productos
            //un div, con la imagen, con el titulo que es el nombre y el p que es la descripcion
            img.setAttribute("src", "img_productos/"+json[index]["id_producto"]+".jpg")
            //las imagenes de los productos tienen como nombre el mismo id_producto quye tiene el producto en la base de datos
            h4.innerHTML = json[index]["nombre"];
            p.innerHTML = json[index]["descripcion"];
            div.setAttribute("id", "producto;"+json[index]["id_producto"])
            div.appendChild(img);
            div.appendChild(h4);
            div.appendChild(p);
            if(json[index]["stock"]==0){
                div.appendChild(avisar);
            }else{
                div.appendChild(comprar);
            }

            document.getElementById("cuerpo").appendChild(div)
            if (localStorage.getItem("usuario") || sessionStorage.getItem("usuario")) {
                if(json[index]["stock"]==0){
                    document.getElementById("avisar_producto;"+json[index]["id_producto"]).addEventListener("click", avisarProducto);
                }else{
                    document.getElementById("comprar_producto;"+json[index]["id_producto"]).addEventListener("click", comprarProducto);
                }
            }
        }
        //ahora hacemos los botondes de nuemero de pagina
        let div = document.createElement("div");
        //los meteresmo en un div que ira al final de todos los productos
        for (let index = 1; index < Math.ceil((json.length)/cantidad_producto)+1; index++) {
        //el for funciona de la sigueinte forma:
            //aqui pintamos las paginas, por ahora van desde la primera hasta el X
            //ese X se decide haciendo Math.ceil((json.length)/cantidad_producto)+1
            //ejemplo: Math.ceil((7)/4)+1 --> Math.ceil(1,75)+1 --> 2+1 --> 3. ira desde 1, hasta 3, osea que habra 2 pafinas, 1,2
            let a = document.createElement("a")
            a.setAttribute("href", "") //si no lo tiene no se puede pulsar como un link
            a.setAttribute("id", "pagina;"+index) //leva pagina, seguido del numero de pagina que es con el index, y el ";" es para poder recuperar estos dos datos separados con el split(";")
            a.innerHTML=index;
            div.appendChild(a)
        }
        //añado este div con las paginas al cuerpo, al final de los productos
        document.getElementById("cuerpo").appendChild(div)
        //existir
        //los links de paginas que hemos creado antes no existian, y nunca sabemos cuantas pueden ser, asique sus addEventListsener para que cambien los productos cuando se clickea deben crearse tras existir
        for (let index = 1; index < Math.ceil((json.length)/cantidad_producto)+1; index++) {
            //funciona exactamente igual que el anterior for
            //lo que hago es asociar el addEventListener a ids que son pagina;[el numero de esa iteracion], como hicimos al crearlos
            //y estos llaman a otra funcion que no es conexion() ahi se explicara por que
            document.getElementById("pagina;"+index).addEventListener("click", llamado_paso_pagina)
        }
    }

    function llamado_paso_pagina(e){
        e.preventDefault()
        //tenemos que hacer  e.preventDefault() para que el link no recargue la apgina
        conexion(this.id.split(";")[1])
        //hacemos esta funcion para que el this.id funcione, y asi poder recoger de su id que numero de pagina lanzo el evento para asi decirle a conexion() el numero de pagina que to0ca
    }

    //comprar

    function comprarProducto(){
        if(sessionStorage.getItem("carrito")){
            if(!sessionStorage.getItem("carrito").includes(";"+this.id.split(";")[1]+";")){
                sessionStorage.setItem("carrito", sessionStorage.getItem("carrito")+this.id.split(";")[1]+";")
            }
        }else{
            sessionStorage.setItem("carrito", ";"+this.id.split(";")[1]+";")
        }
        
    }

    //avisar

    function avisarProducto(){
        console.log(this.id)
    }

}