<?php

class DataBase extends SQLite3{
    function __construct(){
        $this->open('../database/bdnd_database.db');
    }
}

$validacion = $_GET['validacion'];

switch ($validacion) {
    case "Ingreso": {
            validarIngreso();
            break;
        }
    case "Cuenta": {
            validarCuenta();
            break;
        }
    default: {
            echo "Peticion No valida";
        }
}

die;

function validarIngreso(){
    $numTarjeta = $_POST['numtarjeta'];
    $contrasena = $_POST['contrasena'];

    if (isset($numTarjeta) && isset($contrasena)) {
        if ($numTarjeta != "" && $contrasena != "") {

            $db = new DataBase();

            $sql = <<<EOF
            SELECT CONTRASENA FROM CLIENTE WHERE NUM_TARJETA=$numTarjeta
EOF;

            $ret = $db->query($sql);
            $row = $ret->fetchArray(SQLITE3_ASSOC);
            if ($contrasena == $row['CONTRASENA']) {
                header('Location: ../presentacion/cajero.php?numTarjeta='.$numTarjeta);
            } else {
                echo "Usuario o contraseña incorrectos";
            }

            $db->close();
        } else {
            echo "Por favor ingrese todos los datos";
        }
    } else {
        errorEnvio();
    }
}

function validarCuenta(){
    $numTarjeta = $_POST['input'];

    if (isset($numTarjeta)) {
        if ($numTarjeta != "") {

            $db = new DataBase();

            $sql = <<<EOF
            SELECT NUM_TARJETA FROM CLIENTE WHERE NUM_TARJETA=$numTarjeta
EOF;

            $ret = $db->query($sql);
            $row = $ret->fetchArray(SQLITE3_ASSOC);
            if($row!=null){
                echo json_encode(TRUE);
            } else {
                echo json_encode(FALSE);
            }

        } else {
            echo "ingrese todos los datos";
        }
    } else {
        errorEnvio();
    }
}

function errorEnvio(){
    echo "Error en el envio de datos";
}
