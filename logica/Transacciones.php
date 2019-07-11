<?php

class DataBase extends SQLite3{
    function __construct(){
        $this->open('../database/bdnd_database.db');
    }
}

$transaccion = $_POST['transaccion'];
switch($transaccion){
    case "Retiro": {
        Retiro();
        break;
    }
    case "Transferencia": {
        Transferencia();
        break;
    }
    case "ConsultaSaldo": {
        ConsultaSaldo();
        break;
    }
    case "ConsultaDatos": {
        ConsultaDatos();
        break;
    }
    case "ConsultaMovimientos": {
        ConsultaMovimientos();
        break;
    }
    default:{
        echo "peicion no valida";
    }
}

function Retiro(){
    $valor=$_POST['val'];
    $numTarjeta=$_POST['num'];
    $auxiliar=0;
    $id=0;
    if(isset($valor) && isset($numTarjeta)){
        $db= new DataBase();
    
        $sql1=<<< EOF
            SELECT SALDO, ID from CLIENTE where NUM_TARJETA=$numTarjeta;
EOF;
    
        $ret1=$db->query($sql1);
    
        $row=$ret1->fetchArray(SQLITE3_ASSOC);
        $auxiliar= $row['SALDO']-$valor;
        if($auxiliar<0){
            echo json_encode("NoMoney");
        } else {
            $id=$row['ID'];
        
            $sql2 =<<< EOF
                UPDATE CLIENTE set SALDO=$auxiliar where NUM_TARJETA=$numTarjeta;
                INSERT INTO RETIRO (CONSECUTIVO,ID,VALOR)
                VALUES (null,$id,$valor);
EOF;
            $db->exec($sql2);
            echo json_encode("Success");
        }
    } else {
        echo FALSE;
    }
    
}

function Transferencia(){
    $valor=$_POST['val'];
    $numTarjeta=$_POST['num'];
    $destino=$_POST['dest'];

    if(isset($valor) && isset($numTarjeta) && isset($destino)){
        $db= new DataBase();
    
        $sql1=<<< EOF
            SELECT SALDO, ID from CLIENTE where NUM_TARJETA=$numTarjeta;
EOF;
    
        $ret1=$db->query($sql1);

        $row1=$ret1->fetchArray(SQLITE3_ASSOC);
        $auxiliar1= $row1['SALDO']-$valor;

        $sql2=<<< EOF
            SELECT SALDO, ID from CLIENTE where NUM_TARJETA=$destino;
EOF;
    
        $ret2=$db->query($sql2);

        $row2=$ret2->fetchArray(SQLITE3_ASSOC);
        $auxiliar2= $row2['SALDO']+$valor;
        $idest=$row2['ID'];
        if($auxiliar1<0){
            echo json_encode("NoMoney");
        } else {
            $id=$row1['ID'];
        
            $sql3 =<<< EOF
                UPDATE CLIENTE set SALDO=$auxiliar2 where NUM_TARJETA=$destino;
                UPDATE CLIENTE set SALDO=$auxiliar1 where NUM_TARJETA=$numTarjeta;
                INSERT INTO RETIRO (CONSECUTIVO,ID,VALOR) VALUES (null,$id,$valor);
                INSERT INTO TRANSFERENCIA (CONSECUTIVO,ID,VALOR,DESTINO,ORIGEN) VALUES (null,$id,$valor,$destino,TRUE);
                INSERT INTO TRANSFERENCIA (CONSECUTIVO,ID,VALOR,DESTINO,ORIGEN) VALUES (null,$idest,$valor,$numTarjeta,FALSE);
EOF;
            $db->exec($sql3);
            echo json_encode("Success");
        }

    }else{
        echo FALSE;
    }
}

function ConsultaSaldo(){
    $numTarjeta=$_POST['num'];

    if(isset($numTarjeta)){
        $db= new DataBase();
    
        $sql=<<< EOF
            SELECT SALDO, ID from CLIENTE where NUM_TARJETA=$numTarjeta;
EOF;
    
        $ret=$db->query($sql);

        $row=$ret->fetchArray(SQLITE3_ASSOC);
        echo json_encode($row['SALDO']);
    }else{
        echo FALSE;
    }
}

function ConsultaDatos(){
    $numTarjeta=$_POST['num'];

    if(isset($numTarjeta)){
        $db= new DataBase();
    
        $sql=<<< EOF
            SELECT * from CLIENTE where NUM_TARJETA=$numTarjeta;
EOF;
    
        $ret=$db->query($sql);

        $row=$ret->fetchArray(SQLITE3_ASSOC);
        echo json_encode(
            "<div class='container text-left'>".
            "<b>Nombre:</b> ".$row['PRIMER_NOMBRE']." ".$row['SEGUNDO_NOMBRE']." ".$row['PRIMER_APELLIDO']." ".$row['SEGUNDO_APELLIDO']."<br><br>".
            "<b>Identificacion:</b> ".$row['IDENTIFICACION']."<br><br>".
            "<b>Numero de Tarjeta:</b> ".$row['NUM_TARJETA']."<br><br>".
            "<b>ID de cliente:</b> ".$row['ID'].
            "</div>"
        );
    }else{
        echo FALSE;
    }
}

function ConsultaMovimientos() {
    $numTarjeta=$_POST['num'];

    if(isset($numTarjeta)){
        $db= new DataBase();
    
        $sql=<<< EOF
            SELECT * from CLIENTE where NUM_TARJETA=$numTarjeta;
EOF;
    
        $ret=$db->query($sql);
        $row=$ret->fetchArray(SQLITE3_ASSOC);
        $id=$row['ID'];

        $sql2=<<< EOF
            SELECT VALOR from RETIRO where ID=$id;
EOF;

        $trans = "";

        $ret1=$db->query($sql2);
        while($row=$ret1->fetchArray(SQLITE3_ASSOC)){ 
            $trans = "".$trans."retiro por valor de $".$row['VALOR']."<br><br>";
        }

        $sql3=<<< EOF
            SELECT VALOR,DESTINO,ORIGEN from TRANSFERENCIA where ID=$id;
EOF;

        $ret2=$db->query($sql3);
        while($row=$ret2->fetchArray(SQLITE3_ASSOC)){
            if($row['ORIGEN']){
                $trans = "".$trans."transferencia para ".$row['DESTINO']." por valor de $".$row['VALOR']."<br><br>";
            } else {
                $trans = "".$trans."transferencia desde ".$row['DESTINO']." por valor de $".$row['VALOR']."<br><br>";
            }    
        }

        echo json_encode($trans);
    }else{
        echo FALSE;
    }
}

?>