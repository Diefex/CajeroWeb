<?php
//$cuenta = $_POST['cuenta'];
$op = 0;
$btn = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cajero Virtual</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
</head>
<body>

    <div class="container-fuid py-md-5">
        <div class="p-md-5 bg-secondary">
            <div class="container min-w-50 bg-dark p-md-5 rounded-lg">
                <div class="row">
                    <!--Panel de Botones Izquierdo-->
                    <div class="bg-secondary rounded col-2 p-md-3 mt-md-5">
                        <?php
                        $btn=0;
                        for ($i = 0; $i < 4; $i++) {
                            echo "
                            <div class='row container-fluid align-items-center ml-auto' style='height: 150px'>
                                <button id='btn$btn' type='button' class='btn btn-success w-100 my-md-5 text-right'>
                                    <img src='Recursos/RightArrow.svg' alt='Boton$i' style='height: 25px'>
                                </button>
                            </div>";
                            $btn+=2;
                        }
                        ?>
                    </div>
                    <!--Pantalla-->
                    <div id="pantalla" class="bg-light col-7 rounded-lg mx-auto">
                        <!--Titulo-->
                        <div class="row pt-md-2">
                            <h2 id="titulo" class="mx-auto">Seleccione el tramite que desea realizar</h2>
                        </div>
                        <div class="row">
                            <!--Opciones barra izquierda-->
                            <div class="col p-md-3">
                                <?php
                                $op=0;
                                for ($i = 0; $i < 4; $i++) {
                                    echo "<div class='row container-fluid align-items-center mr-auto' style='height: 150px'>
                                        <h5 class='text-left mr-auto' id='campo$op'></h5>
                                    </div>";
                                    $op+=2;
                                }
                                ?>
                            </div>
                            <!--Opciones barra derecha-->
                            <div class="col p-md-3 text-right">
                                <?php
                                $op=1;
                                for ($i = 0; $i < 4; $i++) {
                                    echo "<div class='row container-fluid align-items-center ml-auto' style='height: 150px'>
                                        <h5 class='text-right ml-auto' id='campo$op'></h5>
                                    </div>";
                                    $op+=2;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!--Panel de Botones Derecho-->
                    <div class="bg-secondary rounded col-2 p-md-3 mt-md-5">
                        <?php
                        $btn=1;
                        for ($i = 0; $i < 4; $i++) {
                            echo "
                            <div class='row container-fluid align-items-center mr-auto' style='height: 150px'>
                                <button id='btn$btn' type='button' class='btn btn-success w-100 my-md-5 text-left'>
                                    <img src='Recursos/LeftArrow.svg' alt='Boton$i' style='height: 25px'>
                                </button>
                            </div>";
                            $btn+=2;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="pantalla.js"></script>
</body>
</html>