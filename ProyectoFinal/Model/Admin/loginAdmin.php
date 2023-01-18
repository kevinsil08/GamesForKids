<?php
    session_start();
    $principal_path= '../../View/Admin/dashboardAdmin.php';
    $secundary_path= '../../View/Admin/loginAdmin.php';

    $id=null;
    $email = $_POST['user'];
    $passwordUser = $_POST['pass'];
    $verificar=null;

    include '../Database/Connection.php';
    include '../Database/Funciones.php';
    global $conn;
//
    $verificar = loginAdmin($conn, $email, $passwordUser);

    //$md5pass = md5($passwordUser);
    if($verificar['adm_email'] == $email && $verificar['adm_password'] == $passwordUser){
        $_SESSION["admin_id"] = $verificar['adm_id'];
        header("Location: $principal_path");
    }else{
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
?>