/*

let precio = 0;

document.getElementById("paypal-button-container").addEventListener("hover", determinarPrecio)

function determinarPrecio(){
    precio = parseFloat(document.getElementById("totalMasIva").innerText).toFixed(2)
    console.log(precio);
}

function compraRealizada(detalles){}*/

/**
 
<div id="paypal-button-container"></div>  
        
            <script src="https://www.paypal.com/sdk/js?client-id=Ab-pjiPTvH0T_SFtqwnt_eNHo7RLQON6T6u01aWjkqrFOpdg32yMloGaDU7UnQ4OX2nZ8TvaKUzs6w_Q&currency=EUR"></script>

            <script src="script/scriptpaypal.js"></script>

            <script>
            paypal.Buttons({
                createOrder: function(data, actions){
                    return actions.order.create({
                        purchase_units:[{
                            amount:{
                                value:precio //dinero
                            }
                        }]
                    //})
                //},
            
                //onApprove: function(data/* cintiene toda la informacion que se va a tratar*///, //actions /* indica funciones que puda realizar*/){
                    //actions.order.capture().then(function(detalles){
                        //compraRealizada(detalles)
                    //})
                //},
            
                //onCancel: function(data){//esto se lanza cuando el usuario cancela el pago
                    //alert("pago cancelado")
                //}
            //}).render('#paypal-button-container')
            //</script>
