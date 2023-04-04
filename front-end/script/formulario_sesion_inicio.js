window.addEventListener("load", funciones)

function funciones (){
    //cambio de formulario
    let inicio_sesion =  document.getElementById("inicio_sesion");
    let resgistrarse =  document.getElementById("resgistrarse");
    document.getElementById("boton_para_registrarse").addEventListener("click", cambiar_formulaio)
    document.getElementById("boton_para_iniciar_sesion").addEventListener("click", cambiar_formulaio)
    
    function cambiar_formulaio(){ //para cambiar el formulaio de inicio de sesion y de registro
        if(this.id.includes("iniciar")){
            inicio_sesion.style.display="block"
            resgistrarse.style.display="none"
        }else{
            inicio_sesion.style.display="none"
            resgistrarse.style.display="block"
        }
    }

    //enviar informacion del formulario

    function conexion(){
        //creamos el obejto para hacer la conexion
        const http = new XMLHttpRequest();
        //metemos en otra variable la direccion donde 
        //esta ar archivo del servidor con el que queremos conectarnos
        const url = "../../back-end/sesion.php";

        

    }

}