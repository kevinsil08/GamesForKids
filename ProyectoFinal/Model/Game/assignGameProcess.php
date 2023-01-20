<?php
    session_start();
    if(empty($_SESSION['tch_id'])){
        session_destroy();
        header("Location: ../../index.php");
    }
    $principal_path= '../../View/Teacher/dashboardTeacher.php';
    $id_teacher=$_SESSION["tch_id"];
      
    include '../../Model/Database/Connection.php';
    include '../../Model/Teacher/functionsDatabase.php';
    include '../../Model/Game/functionsDatabase.php';
    
    global $conn;
    $teacher = selectTeacher($conn, $id_teacher);

    var_dump($_POST);
    $passwd_generated =  uniqid($teacher['tch_name']);

    $id_type_game = getTypeGame();
    $id_type_game = $_POST[$id_type_game];

    var_dump($id_type_game);

    $result = insertMatch($conn,$id_teacher,$id_type_game,$passwd_generated);
    $result_match_id = selectLastMatchWithPassword($conn,$id_teacher,$passwd_generated);
    insertQuestionsAnswers($conn,$result_match_id['mtg_id']);

    if($result && $result_match_id != null){
        $_SESSION["passwd_generated"] = $passwd_generated;
        header("Location: $principal_path?juego=generado");
    }else{
        header("Location: $principal_path?mensaje=error");
        exit();
    }

    function getTypeGame(){
        $type = "type_game";
        $NUMBER_GAMES = 2;
        for($x=0; $x<$NUMBER_GAMES;$x++){
            if(!empty($_POST[$type.$x])){
                $type = $type.$x;
                break;
            }
        }
        return $type;
    }

    function insertQuestionsAnswers($conn,$id_match){
        $type = "type_answer";
        for($x=1;$x<count($_POST);$x++){
            $type_answer=$_POST[$type.$x];
            insertMatchQuestionsAnswers($conn,$id_match,$type_answer,'T');
        }
    }

?>