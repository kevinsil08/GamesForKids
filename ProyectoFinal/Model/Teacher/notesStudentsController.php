<?php 
session_start();
$principal_path = "../../View/Teacher/notesStudentsTeacher.php";
$secundary_path = "../../View/Teacher/dashboardTeacher.php";

if(empty($_POST)){
    header("Location: ../../index.php");
    exit();
}

if(!isset($_POST['txtSince']) || !isset($_POST['txtTo']) || !isset($_POST['id_teacher'])){
    header("Location: ../../index.php");
    exit();
}

$date_before = $_POST['txtSince'];
$date_after = $_POST['txtTo'];
$id_teacher = $_POST['id_teacher'];

include '../Database/Connection.php';
include '../Game/functionsDatabase.php';

    global $conn;
                    
    $lista = get_califications_students_with_dates($conn, $id_teacher,$date_before,$date_after);


if(count($lista)>0){
    header("Location: $principal_path?tabla=mostrar&primera=$date_before&segunda=$date_after");
}else{
    header("Location: $secundary_path?mensaje=error");
    exit();
}



?>
