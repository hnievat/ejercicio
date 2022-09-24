<?php

require_once('../Modelo/empleados.php');

if (!empty($_POST["login"])) {
    session_start();
    $Modelo = new Empleados();
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $isLoggedIn = $Modelo->login($email);
    if (!$isLoggedIn) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    } else {
        header('Location:../../home.php');
    }
}else{
    header('Location: ../../index.php');
}

?>

<?php

?>