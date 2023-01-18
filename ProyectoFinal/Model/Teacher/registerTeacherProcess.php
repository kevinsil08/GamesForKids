<?php
    session_start();
    $principal_path= '../../View/Teacher/dashboardTeacher.php';
    $secundary_path= '../../View/Teacher/registerTeacher.php';
    if(empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['email']) 
    || empty($_POST['pass']) ){
        header("Location: $secundary_path?mensaje=falta");
        exit();
    }

    // if($_POST['pass'] != $_POST['txtConfirmPassword']){
    //     header("Location: $secundary_path?mensaje=contra");
    //     exit();
    // }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';
    include '../../SecurityToken.php';

    $name = $_POST['nombre'];
    $last_name = $_POST['apellido'];
    $email = $_POST['email'];
    $password_teacher = $_POST['pass'];

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