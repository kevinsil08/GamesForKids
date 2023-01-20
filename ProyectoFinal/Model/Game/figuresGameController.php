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

    global $conn;
    
    if(($_POST['passwd']) == null){
        echo "a";
        $_SESSION['match_type'] = 'random'; 
        $id_match_game = createMatch($id_type_game,$id_teacher);

    }else if(isset($_POST['passwd'])){
        $passwd_match = $_POST['passwd'];

        $match_passwd = selectLastMatch($conn,$id_teacher,$passwd_match);//passwd match 

        if($match_passwd['mtg_password'] !=$passwd_match){
            header("Location: ../../View/Student/startFiguresGame.php?mensaje=contra");
            exit();
        }

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

    
    $detail_only_game = listDetailGames($conn,$id_type_game); //detail_only_game -> Regresa los detalles del tipo de juego 'Figuras' de la DB
    $_SESSION['list_detail_games'] = $detail_only_game; //Se inicializa 'list_detail_games' con la variable $detail_only_game

    $figures = array();//Se inicializa un array vacío
    $figures = getNamesFigures($figures,$detail_only_game);

    /*
       $_SESSION['figures'] -> nombre de los detalles del tipo de juego ['figures'] guardadas en la DB
    */
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

    /*
        $figures -> array vacío
        $detail_games -> detalles del tipo de juego seleccionado 'figures'
    */
    function getNamesFigures($figures, $detail_games){
        for($x=0;$x<count($detail_games);$x++){//Recorre el arreglo de los detalles del tipos de juego 'figures' 
            //['dtg_detail'] -> es el nombre de la columna que regresa la consulta a la DB
            array_push($figures, $detail_games[$x]['dtg_detail']);//Se guarda en $figures los nombres de los detalles del tipo de juego   
        }

        return $figures;//retorna el array del nombre de las figuras
    }

    /*
        Se crea un match
        $id_type_game -> Id del tipo de juego 'Figuras'
        $id_teacher -> Id del Teacher del Estudiante
    */
    function createMatch($id_type_game,$id_teacher){
        global $conn;

        /*
            Se inserta el match en la DB
            $result -> devuelve la fecha creada(timestamp) del match
        */
        $result = insertMatch($conn,$id_teacher,$id_type_game,'null');
        $result_match_id = selectLastMatchRandom($conn,$id_teacher,$result);

        if($result_match_id != null){//Si está todo correcto y es diferente de null, se devuelve la Id del match creado
            return $result_match_id['mtg_id'];
        }

        return null;
        
    }


?>
