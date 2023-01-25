<?php
    session_start();
    $principal_path= 'sesionTch.php';
    $secundary_path= 'teacher.php';

    $id=null;
    $email = $_POST['user'];
    $passwordUser = $_POST['pass'];
    $verificar=null;
    global $conn;

    include '../Database/Connection.php';
    include '../Database/Funciones.php';

    $verificar = loginTch($conn, $email, $passwordUser);

    $md5pass = md5($passwordUser);
    if($verificar['tch_email'] == $email && $verificar['tch_password'] == $md5pass){
        $_SESSION["tch_id"] = $verificar['tch_id'];
        header("Location: $principal_path");
    }else{
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
?>