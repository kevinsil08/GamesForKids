<?php
    session_start();
    $principal_path= '../../View/Teacher/studentsTeacher.php';
    $second_path= '../../View/Admin/studentsAdmin.php';
    if(!isset($_POST['codigo'])){
        header("Location: ../../index.php");
        exit();
    }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';
    include '../../SecurityToken.php';

    $id=$_POST['codigo'];
    $name = $_POST['txtNombre'];
    $passport = $_POST['txtPassport'];
    $last_name = $_POST['txtApellido'];
    $id_teacher = $_POST['id_teacher'];
    $email_student = $_POST['txtEmail'];
    $passwd_student = $_POST['txtPasswd'];
    $date_birth_student = $_POST['date_student'];
    $sex_student = $_POST['sex_student'];

    global $conn;
    
    $verificar = updateStudent($conn, $id, $passport,$name, $last_name, $passwd_student, $email_student,$date_birth_student,$sex_student);
    $encrypt_id_teacher = secureToke::tokenencrypt($id_teacher);
    if($verificar === TRUE){

        $type= $_POST['type_edit'];

        if($type == "admin"){
            header("Location: $second_path?mensaje=actualizado");
            exit();
        }

        header("Location: $principal_path?mensaje=actualizado&K3pNblN0cFBoU1pJam8zWGpMUFJGZz09=$encrypt_id_teacher");
    }else{
        header("Location: $principal_path?mensaje=error&K3pNblN0cFBoU1pJam8zWGpMUFJGZz09=$encrypt_id_teacher");
        exit();
    }
?>