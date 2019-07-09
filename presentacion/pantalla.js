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

    printForm(texto, accion) {
        this.hold.innerHTML = `
        <div class="container text-center">
            <form class="my-md-5" id="form">
                <h2 class="py-md-5">${texto}</h2>
                <input id="input" name="input" type="text" class="form-control" autocomplete="off">
                <button id="btn" type="submit" class="btn btn-success my-md-5">Ingresar</button>
            </form>
        </div>`;
        var formulario =document.getElementById('form');
        formulario.addEventListener('submit',accion);
    }

    ingresarValor(accion){
        this.printForm("Ingrese el Valor", function(){accion(document.getElementById('input').value)});
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

//fucniones de Retiro-----------------------------------------------
function Retiro() {
    pantalla.setTitulo("Seleccione la cantidad a retirar");
    //Opciones
    var opf = new OpcionFactory();
    opf.newOpcion("retirarValor(10000)", "$ 10000");
    opf.newOpcion("retirarValor(50000)", "$ 50000");
    opf.newOpcion("retirarValor(100000)", "$ 100000");
    opf.newOpcion("retirarValor(500000)", "$ 500000");
    opf.newOpcion("retirarValor(1000000)", "$ 1000000");
    opf.newOpcion("pantalla.ingresarValor(retirarValor)", "Otro Valor");
    opf.opcionSalir();
}

function retirarValor(valor) {

    pantalla.print("Retirando $" + valor + " de la cuenta"+cuenta+"<br> Por favor tome su dinero");

}

//------------------------------------------------------------------
function Consulta() { 
}
function Transferencia() {
    pantalla.printForm("Indique la cuenta destino", function(e){
        e.preventDefault();
        var cuenta =new FormData (document.getElementById('form'));

        fetch('../logica/Validaciones.php?validacion=Cuenta',{
            method:'POST',
            body: cuenta
        })
            .then(res=>res.json())
            .then(validado =>{
                if(validado){
                    this.destino = document.getElementById('input').value;
                    pantalla.ingresarValor(transferirValor);
                } else {
                    pantalla.print("Esta Cuenta No Existe");
                }
            })
    });

 }

 function transferirValor (valor){
    pantalla.print("Transfiriendo "+valor+" a la cuenta "+destino);
 }

//Salir------------------------------------------------------------
function Salir() {
    window.location="Login.php";
}
//main-------------------------------------------------------------
var pantalla = new Screen();
var cuenta;
var destino;

init();

//Inicializacion de las opciones en pantalla y los eventos de los botones
function init() {
    var opf = new OpcionFactory();

    opf.newOpcion("Retiro()", "Retirar Efectivo");
    opf.newOpcion("Consulta()", "Consultar Saldo y Movimientos");
    opf.newOpcion("Transferencia()", "Transferencias");
    opf.opcionSalir();

}
