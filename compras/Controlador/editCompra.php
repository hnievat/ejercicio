<?php
    require_once('../Modelo/compras.php');

    if($_POST){
        $Modelo = new Compras();
        $id = $_POST['id'];
        $id_proveedor = $_POST['id_proveedor'];
        $id_producto = $_POST['id_producto'];
        $fecha_pedido = $_POST['fecha_pedido'];
        $fecha_factura = $_POST['fecha_factura'];
        $importe = $_POST['importe'];
        $no_pedido = $_POST['no_pedido'];
        $Modelo->setCompra($id, $id_proveedor, $id_producto, $fecha_pedido, $fecha_factura, $importe, $no_pedido);

    }else{
        header('Location: ../../index.php');
    }
?>