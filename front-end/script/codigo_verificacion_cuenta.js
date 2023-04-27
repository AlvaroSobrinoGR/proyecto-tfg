window.addEventListener("load", funciones)

function funciones(){
    window.addEventListener("beforeunload", cancelar)
    
    function cancelar(){
        conexion("confirmar", codigo)
    }

    document.getElementById("confirmar").addEventListener("click", confirmar)

    function confirmar(){
        let codigo = document.getElementById("codigo_confirmacion").value
        if(codigo.length>0){
            conexion("confirmar", codigo)
        }
    }

    function conexion(tipo, valor){
        let formulario = new FormData();
        formulario.append("codigo", codigo)

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../back-end/codigo_verificacion_cuenta.php")
        xhr.addEventListener("load", (respuesta)=>{
            let resultado = respuesta.target.response;
            if(resultado.includes("correcto")){
                localStorage.setItem("usuario", resultado.split(";")[1])
                window.location.href = "inicio.html"
            }else{
                ocultar_contenido()
            }
        })
        xhr.send(formulario);
    }

}