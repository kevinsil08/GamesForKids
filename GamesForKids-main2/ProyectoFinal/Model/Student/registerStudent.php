<?php
    $principal_path= '../../View/Teacher/studentsTeacher.php';
    if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['id_teacher']) || empty($_POST['txtPassport'])){
        header("Location: $principal_path?mensaje=falta");
        exit();
    }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';
    include '../../SecurityToken.php';

    $name = $_POST['txtNombre'];
    $passport = $_POST['txtPassport'];
    $last_name = $_POST['txtApellido'];
    $id_teacher = $_POST['id_teacher'];
    $email_student = $_POST['txtEmail'];
    $passwd_student = $_POST['txtPasswd'];
    $date_birth_student = $_POST['date_student'];
    $sex_student = $_POST['sex_student'];

    global $conn;
    $verificar = insertStudent($conn, $name,$passport ,$last_name, $passwd_student, $email_student,$date_birth_student,$sex_student, $id_teacher);
    $encrypt_id_teacher = secureToke::tokenencrypt($id_teacher);
    if($verificar){
        header("Location: $principal_path?mensaje=registrado");
    }else{
        header("Location: $principal_path?mensaje=error");
        exit();
    }
?>

