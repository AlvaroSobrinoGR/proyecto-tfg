window.addEventListener("load", funciones)

function funciones(){

    let queryParams = new URLSearchParams(window.location.search);
    if(queryParams.get('hash')!=null && queryParams.get('email')!=null){
        let email = queryParams.get('email');
        let codigo = queryParams.get('hash');
        conexion(email, codigo)
    }
    
    

    function conexion(email, codigo){
        let formulario = new FormData();
        formulario.append("email", email)
        formulario.append("codigo", codigo)

        let php = "back-end/codigo_verificacion_cuenta.php";
        if(!window.location.pathname.includes("index.html")){
            php = "../back-end/codigo_verificacion_cuenta.php";
        }
        

        let xhr = new XMLHttpRequest();
        xhr.open("POST", php)
        xhr.addEventListener("load", (respuesta)=>{
           //console.log(respuesta.target.response);
        })

        xhr.send(formulario);
    }


}