<?php
    $principal_path= '../../View/Teacher/studentsTeacher.php';
    if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['id_teacher'])){
        header("Location: $principal_path?mensaje=falta");
        exit();
    }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';
    include '../../index.php';

    $name = $_POST['txtNombre'];
    $last_name = $_POST['txtApellido'];
    $id_teacher = $_POST['id_teacher'];

    global $conn;
    $verificar = insertStudent($conn, $name, $last_name, $id_teacher);
    $encrypt_id_teacher = secureToke::tokenencrypt($id_teacher);
    if($verificar){
        header("Location: $principal_path?mensaje=registrado");
    }else{
        header("Location: $principal_path?mensaje=error");
        exit();
    }
?>

