<?php
    require_once('../Modelo/proveedores.php');

    if($_POST){
        $Modelo = new Proveedores();
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $Modelo->addProveedor($nombre, $correo, $direccion);
    }else{
        header('Location: ../../index.php');
    }
?>