<?php
session_start();
if(!empty($_SESSION["userId"])) {
    require_once('empleados/Modelo/empleados.php');
    $Modelo = new Empleados();
    $Empleado = $Modelo->getEmpleado($_SESSION["userId"]);
    if (!$Empleado) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    } else {
        header('Location: home.php');
    }
} else {
    require_once 'login.php';
}
?>