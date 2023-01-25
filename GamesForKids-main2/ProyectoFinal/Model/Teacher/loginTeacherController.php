<?php
    session_start();
    $principal_path= '../../View/Teacher/dashboardTeacher.php';
    $secundary_path= '../../View/Teacher/loginTeacher.php';

    $id=null;
    $email = $_POST['user'];
    $passwordUser = $_POST['pass'];
    $verificar=null;

    include '../Database/Connection.php';
    include '../Database/Funciones.php';
    global $conn;

    $verificar = loginTch($conn, $email, $passwordUser);

    var_dump($verificar);

    //$md5pass = md5($passwordUser);
    if($verificar['tch_email'] == $email && $verificar['tch_password'] == $passwordUser){
        $_SESSION["tch_id"] = $verificar['tch_id'];
        header("Location: $principal_path");
    }else{
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
?>