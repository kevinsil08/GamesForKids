<?php
    session_start();

    include '../../Model/Database/Connection.php';
    include 'functionsDatabase.php';
    var_dump($_SESSION);

    if(empty($_SESSION)){
        session_destroy();
        header("Location: ../../index.php");
    }

    $id_type_game = null;
    if(isset($_SESSION['type_game'])){
        $id_type_game = $_SESSION['type_game'];
    }else{
        session_destroy();
        header("Location: ../../index.php");
    }

    $id_teacher = null;
    if(isset($_SESSION['tch_id'])){
        $id_teacher = $_SESSION['tch_id'];
    }else{
        session_destroy();
        header("Location: ../../index.php");
    } 

    $passwd_match = null;
    $match_type = null;

    var_dump($_POST);
    
    if(($_POST['passwd']) == null){
        echo "a";
        $_SESSION['match_type'] = 'random'; 
        $id_match_game = createMatch($id_type_game,$id_teacher);

    }else if(isset($_POST['passwd'])){
        $passwd_match = $_POST['passwd'];
        $_SESSION['passwd'] =$passwd_match;
        $_SESSION['match_type'] = 'teacher';    

    }else{
        header("Location: ../../View/Student/dashboard.php");
    }

    $match_type = $_SESSION['match_type'];

    $score = null;
    if(isset($_SESSION['puntuacion'])){
        $score = $_SESSION['puntuacion'];
    }else{
        session_destroy();
        header("Location: ../../index.php");
    }

    $quantity_questions = null;
    if(isset($_SESSION['cantidad'])){
        $quantity_questions = $_SESSION['cantidad'];
    }else{
        session_destroy();
        header("Location: ../../index.php");
    }

    global $conn;
    $detail_only_game = listDetailGames($conn,$id_type_game);
    $_SESSION['list_detail_games'] = $detail_only_game;

    $figures = array();
    $figures = getNamesFigures($figures,$detail_only_game);
    $_SESSION['figures'] = $figures;

    if($match_type == 'teacher'){
		$id_match_game = findIdMatch($conn,$id_teacher,$passwd_match);
        if($id_match_game == null){
            header("Location: ../../View/Student/startFiguresGame.php?mensaje=error");
        }
		$_SESSION['match_id'] = $id_match_game['mtg_id'];
	}else if($match_type == 'random'){
		$_SESSION['match_id'] = $id_match_game;
	}else{
		session_destroy();
		header("Location: ../../index.php");
	}

    header("Location: ../../View/Student/figuresGame.php");

    function getNamesFigures($figures, $detail_games){
        for($x=0;$x<count($detail_games);$x++){
            array_push($figures, $detail_games[$x]['dtg_detail']);
        }

        return $figures;
    }

    function createMatch($id_type_game,$id_teacher){
        global $conn;

        $result = insertMatch($conn,$id_teacher,$id_type_game,'null');
        $result_match_id = selectLastMatch($conn,$id_teacher);

        if($result && $result_match_id != null){
            return $result_match_id['mtg_id'];
        }else{
            return null;
        }

    }


?>
