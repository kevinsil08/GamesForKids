<?php
    session_start();
    $principal_path= '../../View/Teacher/studentsTeacher.php';

    if(!isset($_GET['aldzU1BpUm9xWXprRVhaTEdpU3JTQT09']) || empty($_SESSION['tch_id'])){
        header("Location: ../../index.php");
    }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';
    include '../../SecurityToken.php';

    $id_teacher=$_SESSION["tch_id"];


    $encrypt_id_student = $_GET['aldzU1BpUm9xWXprRVhaTEdpU3JTQT09'];
    $codigo = secureToke::tokendecrypt($encrypt_id_student);

    global $conn;
    $verificar = deleteStudent($conn, $codigo);
    $encrypt_id_teacher = secureToke::tokenencrypt($id_teacher);
    
    if($verificar === TRUE){
        header("Location: $principal_path?mensaje=eliminado");
    }else{
        header("Location: $principal_path?mensaje=error");
        exit();
    }
?>