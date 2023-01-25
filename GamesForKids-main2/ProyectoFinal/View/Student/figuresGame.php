<?php
  	session_start();

	include '../../Model/Database/Connection.php';
	include '../../Model/Game/functionsDatabase.php';
	
	if(empty($_SESSION)){//Si el arreglo de las variables de sesión está vacía, se destruye la sesión y se regresa al index.php
		session_destroy();
	    header("Location: ../../index.php");
	}

	$passwd_match = null;
	if(isset($_SESSION['passwd'])){//Si la variable de sesión['passwd'] tiene un valor, se guarda en la variable $passwd_match
		$passwd_match = $_SESSION['passwd'];
	}

	if(!isset($_SESSION['match_type'])){//Si la variable de sesión['match_type'] está vacía, se destruye la sesión y se regresa al index.php
		session_destroy();
		header("Location: ../../index.php");
	}
	$match_type = $_SESSION['match_type'];
	
	if(!isset($_SESSION['puntuacion'])){//Si la variable de sesión['puntuacion'] está vacía, se destruye la sesión y se regresa al index.php
		session_destroy();
		header("Location: ../../index.php");
	}
	$score = $_SESSION['puntuacion'];

	if(!isset($_SESSION['cantidad'])){//Si la variable de sesión['cantidad'] está vacía, se destruye la sesión y se regresa al index.php
		session_destroy();
		header("Location: ../../index.php");
	}
	$quantity_questions = $_SESSION['cantidad']; 

	if(!isset($_SESSION['type_game'])){//Si la variable de sesión['type_game'] está vacía, se destruye la sesión y se regresa al index.php
		session_destroy();
		header("Location: ../../index.php");
	}
	$id_type_game = $_SESSION['type_game'];

	if(!isset($_SESSION['tch_id'])){//Si la variable de sesión['tch_id'] está vacía, se destruye la sesión y se regresa al index.php
		session_destroy();
		header("Location: ../../index.php");
	}
	$id_teacher = $_SESSION['tch_id'];

	global $conn;

	$figures = $_SESSION['figures'];//$_SESSION['figures'] -> nombre de los detalles del tipo de juego ['figures'] guardadas en la DB
	$id_match_game = $_SESSION['match_id']; //$_SESSION['match_id'] -> Id del match actual
	$detail_only_game = $_SESSION['list_detail_games']; //detail_only_game -> Regresa los detalles del tipo de juego 'Figuras' de la DB

	$result = null;
	if($match_type == 'teacher'){ //Se compara si el tipo de match ha sido creado por el Profesor

		$id_detail_game = listMatchQuestionsAnswers($conn,$id_match_game);
		$_SESSION['match_questions_answers_id'] = $id_detail_game[$quantity_questions]['mtch_qst_id'];
		$_SESSION['detail_game_correct_answer_id'] = $id_detail_game[$quantity_questions]['dtg_correct_answer'];
		$result = type_manual($detail_only_game,$id_detail_game[$quantity_questions]['dtg_correct_answer'],$figures);

	}else if($match_type == 'random'){ //Se compara si el tipo de match ha sido creado aleatoriamente

		$random_number_figure = rand(0,count($detail_only_game)-1);
		$id_detail_game = getIdDetailGame($detail_only_game,$random_number_figure);
		$_SESSION['detail_game_correct_answer_id'] = $id_detail_game;
		$result = getNameDetailRandom($detail_only_game,$figures,$random_number_figure);
		insertMatchQuestionsAnswers($conn,$id_match_game,$id_detail_game,'R');
		$id_match_questions_answers = selectLastMatchQuestionsAnswers($conn,$id_match_game);
		$_SESSION['match_questions_answers_id'] = $id_match_questions_answers['mtch_qst_id'];
		
	}else{//Si no es ninguna de las anteriores opciones, se destruye la sesión y se regresa al index.php
		session_destroy();
		header("Location: ../../index.php");
	}

	$select_figure=$figures[$result];

	$_SESSION['figure_correct'] = $select_figure;

	function type_manual($detail_games,$id_detail_game,$figures){
		$name_figure = null;
		for($x=0;$x<count($detail_games);$x++){
			if($detail_games[$x]['dtg_id'] == $id_detail_game){
				$name_figure = $detail_games[$x]['dtg_detail'];
				break;
			}
		}

		return getNameDetail($figures,$detail_games,$name_figure);
	}

	function getNameDetail($figures,$detail_games,$name_figure){
		for($x=0;$x<count($figures);$x++){
			if($detail_games[$x]['dtg_detail'] == $name_figure){
				return $x;
			}
		}
	}

	function getNameDetailRandom($detail_games,$figures,$random_number_figure){
		$name_figure = $detail_games[$random_number_figure]['dtg_detail'];
	 	return getNameDetail($figures,$detail_games,$name_figure);
	}

	function getIdDetailGame($detail_games,$random_number_figure){
		return $detail_games[$random_number_figure]['dtg_id'];
	}
  
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Figuras</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="Css/styles2.css">

</head>
<body>



<div class="containerTitle">
		<header>
			<h2>FIGURAS</h2>
		</header>
	</div>
	
	<!-- divisor de circulos azul -->
	<div class="divisor dark-blue">
		<div class="divisor">
			<svg id="" preserveAspectRatio="xMidYMax meet" class="svg-separator sep3" viewBox="0 0 1600 100" style="display: block;">
				<path class="" style="opacity: 1;fill: #273a4c;" d="M-40,71.627C20.307,71.627,20.058,32,80,32s60.003,40,120,40s59.948-40,120-40s60.313,40,120,40s60.258-40,120-40s60.202,40,120,40s60.147-40,120-40s60.513,40,120,40s60.036-40,120-40c59.964,0,60.402,40,120,40s59.925-40,120-40s60.291,40,120,40s60.235-40,120-40s60.18,40,120,40s59.82,0,59.82,0l0.18,26H-60V72L-40,71.627z"></path>
				<path class="" style="opacity: 1;fill: #2a3f54;" d="M-40,83.627C20.307,83.627,20.058,44,80,44s60.003,40,120,40s59.948-40,120-40s60.313,40,120,40s60.258-40,120-40s60.202,40,120,40s60.147-40,120-40s60.513,40,120,40s60.036-40,120-40c59.964,0,60.402,40,120,40s59.925-40,120-40s60.291,40,120,40s60.235-40,120-40s60.18,40,120,40s59.82,0,59.82,0l0.18,14H-60V84L-40,83.627z"></path>
				<path class="" style="fill: rgb(34, 49, 63);" d="M-40,95.627C20.307,95.627,20.058,56,80,56s60.003,40,120,40s59.948-40,120-40s60.313,40,120,40s60.258-40,120-40s60.202,40,120,40s60.147-40,120-40s60.513,40,120,40s60.036-40,120-40c59.964,0,60.402,40,120,40s59.925-40,120-40s60.291,40,120,40s60.235-40,120-40s60.18,40,120,40s59.82,0,59.82,0l0.18,138H-60V96L-40,95.627z"></path>
			</svg>
			
		</div>
	</div>

	<section class="figures-section">
		<p id="sec-int">Dibuja un <span id="fig-to-select"><?php echo $select_figure;?></span></p>
		<input type="button" id="hablar" style="font-size: 50px; height: 70px; width: 70px;" value="🎙" onclick="decir('Dibuja un '+document.getElementById('fig-to-select').innerHTML)">
		<div class="sec-game">
			<div class="first card">
				<div id ="c0" class="trian"><div class="triangle-border"><div class="triangle-inner"></div></div></div>
			</div>
			<div  class="second card">
				<div id ="c1" class="circle"></div>
			</div>
			<div class="third card">
				<div id ="c2" class="square"></div>
			</div>
		</div>
	</section>

  <div class="camera-div">
        <form class="sec-imgs" method="POST" action="../../Model/API/PostAPIAzure.php">
        <div class="cardVideo">
          <div id="web_cam"></div>   
        </div>   
          <input type=button class="btn-photo"value="Tomar Foto" onClick="take_snapshot()">
          <input type="hidden" name="image" class="image-tag">
          <input type="hidden" name="quantity" value="<?php echo $quantity_questions; ?>">
          <input type="hidden" name="score" value="<?php echo $score; ?>">
          <input type="hidden" name="result" value="<?php echo $select_figure; ?>">
        <div class="cardVideo">
          <div id="copyVideo">Tu imagen aparecerá aquí.</div>
        </div>  
            
            <button id="btn-empezar" style="visibility: hidden;">Subir Foto</button>
        </form> 
  </div>  
	
	<!-- divisor de circulos rojo -->
	
	<div class="divisor red">
		<svg id="" preserveAspectRatio="xMidYMax meet" class="svg-separator sep1" viewBox="0 0 1600 100" data-height="100">
			<path class="" style="opacity: 1;fill: #bc4565;" d="M1040,56c0.5,0,1,0,1.6,0c-16.6-8.9-36.4-15.7-66.4-15.7c-56,0-76.8,23.7-106.9,41C881.1,89.3,895.6,96,920,96
			C979.5,96,980,56,1040,56z"></path>
			<path class="" style="opacity: 1;fill: #bc4565;" d="M1699.8,96l0,10H1946l-0.3-6.9c0,0,0,0-88,0s-88.6-58.8-176.5-58.8c-51.4,0-73,20.1-99.6,36.8
			c14.5,9.6,29.6,18.9,58.4,18.9C1699.8,96,1699.8,96,1699.8,96z"></path>
			<path class="" style="opacity: 1;fill: #bc4565;" d="M1400,96c19.5,0,32.7-4.3,43.7-10c-35.2-17.3-54.1-45.7-115.5-45.7c-32.3,0-52.8,7.9-70.2,17.8
			c6.4-1.3,13.6-2.1,22-2.1C1340.1,56,1340.3,96,1400,96z"></path>
			<path class="" style="opacity: 1;fill: #bc4565;" d="M320,56c6.6,0,12.4,0.5,17.7,1.3c-17-9.6-37.3-17-68.5-17c-60.4,0-79.5,27.8-114,45.2
			c11.2,6,24.6,10.5,44.8,10.5C260,96,259.9,56,320,56z"></path>
			<path class="" style="opacity: 1;fill: #bc4565;" d="M680,96c23.7,0,38.1-6.3,50.5-13.9C699.6,64.8,679,40.3,622.2,40.3c-30,0-49.8,6.8-66.3,15.8
			c1.3,0,2.7-0.1,4.1-0.1C619.7,56,620.2,96,680,96z"></path>
			<path class="" style="opacity: 1;fill: #bc4565;" d="M-40,95.6c28.3,0,43.3-8.7,57.4-18C-9.6,60.8-31,40.2-83.2,40.2c-14.3,0-26.3,1.6-36.8,4.2V106h60V96L-40,95.6
			z"></path>
			<path class="" style="opacity: 1;fill: #af3f5d;" d="M504,73.4c-2.6-0.8-5.7-1.4-9.6-1.4c-19.4,0-19.6,13-39,13c-19.4,0-19.5-13-39-13c-14,0-18,6.7-26.3,10.4
			C402.4,89.9,416.7,96,440,96C472.5,96,487.5,84.2,504,73.4z"></path>
			<path class="" style="opacity: 1;fill: #af3f5d;" d="M1205.4,85c-0.2,0-0.4,0-0.6,0c-19.5,0-19.5-13-39-13s-19.4,12.9-39,12.9c0,0-5.9,0-12.3,0.1
			c11.4,6.3,24.9,11,45.5,11C1180.6,96,1194.1,91.2,1205.4,85z"></path>
			<path class="" style="opacity: 1;fill: #af3f5d;" d="M1447.4,83.9c-2.4,0.7-5.2,1.1-8.6,1.1c-19.3,0-19.6-13-39-13s-19.6,13-39,13c-3,0-5.5-0.3-7.7-0.8
			c11.6,6.6,25.4,11.8,46.9,11.8C1421.8,96,1435.7,90.7,1447.4,83.9z"></path>
			<path class="" style="opacity: 1;fill: #af3f5d;" d="M985.8,72c-17.6,0.8-18.3,13-37,13c-19.4,0-19.5-13-39-13c-18.2,0-19.6,11.4-35.5,12.8
			c11.4,6.3,25,11.2,45.7,11.2C953.7,96,968.5,83.2,985.8,72z"></path>
			<path class="" style="opacity: 1;fill: #af3f5d;" d="M743.8,73.5c-10.3,3.4-13.6,11.5-29,11.5c-19.4,0-19.5-13-39-13s-19.5,13-39,13c-0.9,0-1.7,0-2.5-0.1
			c11.4,6.3,25,11.1,45.7,11.1C712.4,96,727.3,84.2,743.8,73.5z"></path>
			<path class="" style="opacity: 1;fill: #af3f5d;" d="M265.5,72.3c-1.5-0.2-3.2-0.3-5.1-0.3c-19.4,0-19.6,13-39,13c-19.4,0-19.6-13-39-13
			c-15.9,0-18.9,8.7-30.1,11.9C164.1,90.6,178,96,200,96C233.7,96,248.4,83.4,265.5,72.3z"></path>
			<path class="" style="opacity: 1;fill: #af3f5d;" d="M1692.3,96V85c0,0,0,0-19.5,0s-19.6-13-39-13s-19.6,13-39,13c-0.1,0-0.2,0-0.4,0c11.4,6.2,24.9,11,45.6,11
			C1669.9,96,1684.8,96,1692.3,96z"></path>
			<path class="" style="opacity: 1;fill: #af3f5d;" d="M25.5,72C6,72,6.1,84.9-13.5,84.9L-20,85v8.9C0.7,90.1,12.6,80.6,25.9,72C25.8,72,25.7,72,25.5,72z"></path>
			<path class="" style="fill: rgb(210, 77, 87);" d="M-40,95.6C20.3,95.6,20.1,56,80,56s60,40,120,40s59.9-40,120-40s60.3,40,120,40s60.3-40,120-40
			s60.2,40,120,40s60.1-40,120-40s60.5,40,120,40s60-40,120-40s60.4,40,120,40s59.9-40,120-40s60.3,40,120,40s60.2-40,120-40
			s60.2,40,120,40s59.8,0,59.8,0l0.2,143H-60V96L-40,95.6z"></path>
		</svg>
	</div>
	
	
	<footer>
		<div class="score-container">
			<p id="num-aciertos">Tú puedes</p>
		</div>
	</footer>

  
<script src="main.js"></script>

 
</body>
</html> 