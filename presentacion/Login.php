<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ingresar</title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <!--Titulo Bienvenida-->
    <div class="container my-md-5 text-center">
        <h3>
            Ingresando al portal del Banco DND
        </h3>
        <h5>
            por favor complete los siguientes campos
        </h5>
    </div>
    <!--Formulario Login-->
    <div class="container p-md-5 rounded-lg shadow bg-dark text-light">
        <form action="../logica/validaringreso.php" method="POST">
            <div class="form-group">
                <label for="NumTarjeta">Numero de Tarjeta</label>
                <input class="form-control" id="NumTarjeta" placeholder="Ingrese su numero de Tarjeta" autocomplete="off" name="numtarjeta">
            </div>
            <div class="form-group">
                <label for="contra">Contraseña</label>
                <input id="contra" type="password"class="form-control" placeholder="Ingrese su Contraseña" name="contrasena">
                <small  class="form-text text-muted">Su informacion esta totalmente protegida.</small>
            </div>
            <button type="submit" class="btn btn-success">Ingresar</button>
        </form>
    </div>
    <!-- Separador-->
    <div class="container-fluid text-center my-md-5">
        <h3>
            ó si lo prefiere
        </h3>
    </div>
    <!-- Ingresar Tarjeta-->
    <div class="container my-md-5 p-md-5 rounded-lg shadow bg-dark text-light">
        <h3 class="text-center my-md-3">Ingrese su tarjeta</h3>
        <div class="container mx-auto text-center">
            <button class="btn btn-success">Ingresar Tarjeta</button>
        </div>
    </div>
</body>
</html>

