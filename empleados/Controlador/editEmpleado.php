<?php
require_once('../Modelo/empleados.php');

if($_POST){
    $Modelo = new Empleados();
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $desactivado = $_POST['desactivado'];
    $Modelo->setEmpleado($id,$nombre,$apellidos,$direccion,$telefono,$correo,$desactivado);
}else{
    header('Location: ../../index.php');
}

?>