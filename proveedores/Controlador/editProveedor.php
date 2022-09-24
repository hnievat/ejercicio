<?php
    require_once('../Modelo/proveedores.php');

    if($_POST){
        $Modelo = new Proveedores();
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $desactivado = $_POST['desactivado'];
        $Modelo->setProveedor($id, $nombre, $correo, $direccion, $desactivado);

    }else{
        header('Location: ../../index.php');
    }
?>