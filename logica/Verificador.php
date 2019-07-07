<?php
$contra = $_POST['contra'];

if (isset($contra)) {
    if($contra == '1234'){
        echo json_encode(TRUE);
    }else if ($contra == ''){
        echo json_encode('Ingresar Contraseña');
    } else {
        echo json_encode(FALSE);
    }
}  else {
    echo json_encode('Sin Contra');
}
?>