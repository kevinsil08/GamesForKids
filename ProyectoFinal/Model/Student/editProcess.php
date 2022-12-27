<?php
    $principal_path= '../../View/Teacher/studentsTeacher.php';
    if(!isset($_POST['codigo'])){
        header("Location: ../../login.php");
        exit();
    }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';
    include '../../index.php';

    $id=$_POST['codigo'];
    $name=$_POST['txtNombre'];
    $last_name=$_POST['txtApellido'];
    $id_teacher = $_POST['id_teacher'];

    global $conn;
    
    $verificar = updateStudent($conn, $id, $name, $last_name);
    $encrypt_id_teacher = secureToke::tokenencrypt($id_teacher);
    if($verificar === TRUE){
        header("Location: $principal_path?mensaje=actualizado&K3pNblN0cFBoU1pJam8zWGpMUFJGZz09=$encrypt_id_teacher");
    }else{
        header("Location: $principal_path?mensaje=error&K3pNblN0cFBoU1pJam8zWGpMUFJGZz09=$encrypt_id_teacher");
        exit();
    }
?>