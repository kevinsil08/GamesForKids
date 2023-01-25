<?php
    session_start();
    if(empty($_SESSION['tch_id'])){
        session_destroy();
        header("Location: ../../index.php");
    }
    $principal_path= '../../View/Teacher/dashboardTeacher.php';
    $id_teacher=$_SESSION["tch_id"];
      
    include '../../Model/Database/Connection.php';
    include '../../Model/Game/functionsDatabase.php';
    
    global $conn;
    var_dump($_POST);
    $passwd_generated = $_POST['passwd'];

    $result = findIdMatch($conn,$id_teacher,$passwd_generated);

    if($result == null){
        header("Location: $principal_path?mensaje=error");
        exit();
    }
    
    $match_id = $result['mtg_id'];
    $result = finishMatch($conn,$match_id);

    var_dump($result);

   if($result){
        header("Location: $principal_path?juego=finalizado");
    }else{
        header("Location: $principal_path?mensaje=error");
        exit();
    }

?>