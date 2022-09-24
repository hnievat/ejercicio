<?php
    require_once('../Modelo/productos.php');

    if($_POST){
        $Modelo = new Productos();
        $codigo = $_POST['codigo'];
        $marca = $_POST['marca'];
        $estado = $_POST['estado'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $existencia = $_POST['existencia'];
        $id_empleado = $_POST['id_empleado'];
        $id_proveedor = $_POST['id_proveedor'];
        $Modelo->addProducto($codigo, $marca, $estado, $categoria, $precio, $existencia, $id_empleado, $id_proveedor);
    }else{
        header('Location: ../../index.php');
    }
?>