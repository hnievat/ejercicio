<?php

    require_once('../Modelo/compras.php');

    if ($_POST) {
        $Modelo = new Compras();
        
        $Id = $_POST['Id'];
        $Modelo->delete($Id);
    }else{
        header('Location: ../../index.php');
    }
    

?>