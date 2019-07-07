<?php

$numtarjeta=$_POST['numtarjeta'];
$contrasena=$_POST['contrasena'];


class DataBase extends SQLite3{
    function __construct(){
        $this->open('../database/bdnd_database.db');
    }
}

$db=new DataBase();
 
  $sql =<<<EOF
 SELECT CONTRASENA FROM CLIENTE WHERE NUM_TARJETA=$numtarjeta;
EOF;
 $ret = $db->query($sql);
 $row = $ret->fetchArray(SQLITE3_ASSOC);
 if($contrasena==$row['CONTRASENA']){
    header('Location: ../presentacion/cajero.php');
} else {
    echo "Usuario o contraseña incorrectos";
}

 $db->close();

?>