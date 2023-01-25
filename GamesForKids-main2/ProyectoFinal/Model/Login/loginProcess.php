<?php
    session_start();
    $principal_path= '../../View/Teacher/dashboardTeacher.php';
    $secundary_path= '../../login.php';
    if(!isset($_POST['txtEmail']) && !isset($_POST['txtPassword']) && !$_POST['user']){
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
    $id=null;
    $user=$_POST['user'];
    $email = $_POST['txtEmail'];
    $passwordUser = $_POST['txtPassword'];
    $verificar=null;
    global $conn;

    include '../Database/Connection.php';
    if($user === "Teacher"){
        include '../Teacher/functionsDatabase.php';
        $verificar = loginTeacher($conn, $email, $passwordUser);
    }else{
        include '../Student/functionsDatabase.php';
        $verificar = selectStudent($conn, $email);
    }
    
    if($verificar['tch_email'] == $email && $verificar['tch_password'] == $passwordUser){
        $_SESSION["tch_id"] = $verificar['tch_id'];
        header("Location: $principal_path");
    }else{
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
?>