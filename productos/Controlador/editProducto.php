<?php
    require_once('../Modelo/productos.php');

    if($_POST){
        $Modelo = new Productos();
        $id = $_POST['id'];
        $codigo = $_POST['codigo'];
        $marca = $_POST['marca'];
        $estado = $_POST['estado'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $existencia = $_POST['existencia'];
        $id_empleado = $_POST['id_empleado'];
        $id_proveedor = $_POST['id_proveedor'];
        $desactivado = $_POST['desactivado'];
        $Modelo->setProducto($id, $codigo, $marca, $estado, $categoria, $precio, $existencia, $id_empleado, $id_proveedor, $desactivado);

    }else{
        header('Location: ../../index.php');
    }
?>