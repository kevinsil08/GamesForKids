<?php
    session_start();
    $principal_path= '../../View/Teacher/dashboardTeacher.php';
    $secundary_path= '../../View/Teacher/registerTeacher.php';
    if(empty($_POST['txtName']) || empty($_POST['txtLastName']) || empty($_POST['txtEmail']) 
    || empty($_POST['txtPassword']) || empty($_POST['txtConfirmPassword'])){
        header("Location: $secundary_path?mensaje=falta");
        exit();
    }

    if($_POST['txtPassword'] != $_POST['txtConfirmPassword']){
        header("Location: $secundary_path?mensaje=contra");
        exit();
    }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';
    include '../../index.php';

    $name = $_POST['txtName'];
    $last_name = $_POST['txtLastName'];
    $email = $_POST['txtEmail'];
    $password_teacher = $_POST['txtPassword'];

    global $conn;
    $verificar = insertTeacher($conn, $name, $last_name, $email, $password_teacher);
    
    if($verificar==true){
        $teacher = selectLastTeacher($conn);
        $_SESSION["tch_id"] = $teacher['tch_id'];
        header("Location: $principal_path?mensaje=registrado");
    }else{
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
?>