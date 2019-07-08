4//Clase screen----------------------------------------------
class Screen {
    constructor() {
        this.titulo = document.getElementById('titulo');
        this.hold = document.getElementById('pantalla');
    }

    setTitulo(texto){
        this.titulo.innerHTML=texto;
    }

    print(texto) {
        this.hold.innerHTML = `
        <div class="container text-center">
            <h2 class="py-md-5">${texto}</h2>
        </div>`;
    }

    printForm(texto, boton, accion) {
        this.hold.innerHTML = `
        <div class="container text-center">
            <form" class="my-md-5" id="form">
                <h2 class="py-md-5">${texto}</h2>
                <input id="input" type="text" class="form-control">
                <button id="btn" type="submit" class="btn btn-success my-md-5">${boton}</button>
            </form>
        </div>`;
        //document.getElementById('btn').addEventListener('click', accion);
    }


}
//Clase Opcion------------------------------------------------
class Opcion {
    constructor(id, accion, texto) {
        this.campo = document.getElementById('campo' + id);
        this.campo.innerHTML = texto;
        this.btn = document.getElementById('btn' + id);
        this.btn.setAttribute("onclick",accion);
    }

    setOpcion(accion, texto) {
        this.campo.innerHTML = texto;
        this.btn.setAttribute("onclick",accion);
    }
}
//Clase Fabrica de Opciones-----------------------------------
class OpcionFactory {
    constructor() {
        this.opcion = new Array();
        this.index = 0;
        for (var i = 0; i < 8; i++) {
            this.opcion[i] = new Opcion(i, null, "");
        }
    }

    newOpcion(accion, texto) {
        if (this.index < 8) {
            if (this.opcion[this.index] != null) {
                this.opcion[this.index].setOpcion(accion, texto);
            } else {
                this.opcion[this.index] = new Opcion(this.index, accion, texto);
            }
            this.index++;
        } else {
            console.log('No se pudo agregar la opcion ' + texto + ' por que no quedan mas campos de opcion');
        }
    }

    opcionSalir() {
        var aux = this.index;
        this.index = 7;
        this.newOpcion("Salir()", "Salir");
        this.index = aux;
    }
}

//Funciones de Verificacion----------------------------
// function Validar(accion) {
//     pantalla.printFormPass("Ingrese su Clave", "Ingresar");
//     var form = document.getElementById('form');
//     form.addEventListener('submit', function (e) {
//         e.preventDefault();
//         fetch('logica/Verificador.php', {
//             method: 'POST',
//             body: new FormData(form)
//         })
//             .then(response => {
//                 return response.json();
//             })
//             .then(ok => {
//                 if(ok){
//                     accion();
//                 }else{
//                     pantalla.print("Contraseña incorrecta");
//                 }
//             });
//     })
// }

//fucniones de Retiro-----------------------------------------------
// function Retiro() {
//     this.valor = 0;
//     pantalla.setTitulo("Seleccione la cantidad a retirar");
//     //Opciones
//     var opf = new OpcionFactory();
//     opf.newOpcion("retirarValor(10000)", "10000");
//     opf.newOpcion("retirarValor(50000)", "50000");
//     opf.newOpcion("retirarValor(100000)", "100000");
//     opf.newOpcion("retirarValor(500000)", "500000");
//     opf.newOpcion("retirarValor(1000000)", "1000000");
//     opf.newOpcion("ingresarValor", "Otro Valor");
//     opf.opcionSalir();
// }

// function ingresarValor() {
//     pantalla.printForm("Ingrese la Cantidad a Retirar", "retirar", function () {
//         retirarValor(document.getElementById('input').value);
//     });
// }

// function retirarValor(valor) {

//     pantalla.print("Retirando $" + valor + "<br> Por favor tome su dinero");

// }

//------------------------------------------------------------------
function Consulta() { 
}
function Transferencia() {
    this.valor = 0;
    pantalla.printForm("Indique la cuenta destino","Aceptar",null);

    var formulario =document.getElementById('form');
    formulario.addEventListener('submit',function(e){
        console.log("entroooo");
       
        e.preventDefault();
        var datos =new FormData (formulario);

        fetch('ValidarCuenta.php',{
            method:'POST',
            body:datos
        })
            .then(res=>res.json())
            .then(data =>{
                console.log(data)
            })
    });
 }

//  function ingresarMonto(numcuenta){

//     var data =document.getElementById('form');
//     var datos= new FormData(document.getElementById('form'));

//      var metodo={method: 'POST',
//                 body: data};
//     fetch('ValidarCuenta.php',metodo)
//     .then(function(response){
//         var validado=response.json()
//     })
//     .then(function (validado){
//         if(validado){
//             console.log("Esta cuenta existe");
//         }
//         else{
//             console.log("Esta cuenta no existe");
//         }
//     })
//  } 

//Salir------------------------------------------------------------
function Salir() {
    window.location="Login.php";
}
//main-------------------------------------------------------------
var pantalla = new Screen();

init();

//Inicializacion de las opciones en pantalla y los eventos de los botones
function init() {
    var opf = new OpcionFactory();

    opf.newOpcion("Retiro()", "Retirar Efectivo");
    opf.newOpcion("Consulta()", "Consultar Saldo y Movimientos");
    opf.newOpcion("Transferencia()", "Transferencias");
    opf.opcionSalir();

}
