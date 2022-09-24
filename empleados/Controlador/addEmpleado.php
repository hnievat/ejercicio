<?php
require_once('../Modelo/empleados.php');

if($_POST){
    $Modelo = new Empleados();
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $Modelo->addEmpleado($nombre,$apellidos,$direccion,$telefono,$correo);
}else{
    header('Location: ../../index.php');
}

?>