<?php

$valor=$_POST['val'];
$numTarjeta=$_POST['num'];
$auxiliar=0;
$id=0;
if(isset($valor) && isset($numTarjeta)){
    echo "Valor: ".$valor.", numTarjeta:".$numTarjeta;
} else {
    echo FALSE;
}

class DataBase extends SQLite3{
    function __construct(){
        $this->open('../database/bdnd_database.db');
    }
}

$db= new DataBase();

$sql1=<<< EOF
    SELECT SALDO, ID from CLIENTE where NUM_TARJETA=$numTarjeta;
EOF;

$ret1=$db->query($sql1);

$row=$ret1->fetchArray(SQLITE3_ASSOC);
$auxiliar= $row['SALDO']-$valor;
$id=$row['ID'];




$sql =<<< EOF
    UPDATE CLIENTE set SALDO=$auxiliar where NUM_TARJETA=$numTarjeta;
    INSERT INTO RETIRO (CONSECUTIVO,ID,VALOR)
    VALUES (null,$id,$valor);
EOF;

$ret=$db->exec($sql);

/* 
$sql1 =<<< EOF
INSERT INTO RETIRO (CONSECUTIVO,ID,VALOR)
    VALUES (null,$numTarjeta,$valor);
EOF;

$ret1=$db->exec($sql1);


*/
?>