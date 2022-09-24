<?php
    require_once('../Modelo/compras.php');

    if($_POST){
        $Modelo = new Compras();
        $id_proveedor = $_POST['id_proveedor'];
        $id_producto = $_POST['id_producto'];
        date_default_timezone_set($timezone); //?????????????????
        $importe = $_POST['importe'];
        $no_pedido = $_POST['no_pedido'];
        $Modelo->addCompra($id_proveedor, $id_producto, $importe, $no_pedido);
    }else{
        header('Location: ../../index.php');
    }
?>