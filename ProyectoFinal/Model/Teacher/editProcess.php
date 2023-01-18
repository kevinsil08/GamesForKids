<?php
    session_start();
    $principal_path= '../../View/Teacher/dashboardTeacher.php';
    $second_path= '../../View/Admin/teachersAdmin.php';
    if(!isset($_POST['id_teacher'])){
        header("Location: $principal_path?mensaje=error");
        exit();
    }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';

    $name = $_POST['txtNombre'];
    $last_name = $_POST['txtApellido'];
    $email = $_POST['txtEmail'];
    $id_teacher = $_POST['id_teacher'];
    $passwd = $_POST['txtpasswd'];

    global $conn;
    
    $verificar = updateTeacher($conn, $id_teacher, $name, $last_name,$email,$passwd);
    if($verificar === TRUE){
        $type= $_POST['type_edit'];

        if($type == "admin"){
            header("Location: $second_path?mensaje=actualizado");
            exit();
        }
        header("Location: $principal_path?mensaje=actualizado");
    }else{
        header("Location: $principal_path?mensaje=error");
        exit();
    }
?>