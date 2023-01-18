<?php
    session_start();
    $img = $_POST['image'];
    $select_figure= $_POST['result'];
    $score = $_POST['score'];
    $quantity_questions = $_POST['quantity'];
    //$quantity_questions++;
    $folderPath = "Imgs/";//Carpeta donde se guardará la img temporal
  
    $fetch_imgParts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $fetch_imgParts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($fetch_imgParts[1]);
    $img_name = uniqid() . '.png';//se crea la imagen con un id único y con extensión '.png'
  
    $file = $folderPath.$img_name;
    file_put_contents($file, $image_base64);//se manda la imagen a la carpeta anteriormente puesta

    $postBody = file_get_contents($file);//Se obtiene la imagen guardada


    $headers = array('Content-type: application/octet-stream','Training-Key: 07ecc5de41b24d98bd871729f78d0d68');//headers para la API
    $prediction_key = 'Prediction-Key=07ecc5de41b24d98bd871729f78d0d68'; //Key de la prediction de azure
    $curlHandle = curl_init("https://southcentralus.api.cognitive.microsoft.com/customvision/v3.0/Prediction/bfee77cf-1423-4b86-a2ba-fcb2553db987/classify/iterations/Iteration4/image?$prediction_key");//URL autorizado por Azure

    //opciones para el POST de la API
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $postBody); 
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);

    unlink($file);//se borra la imagen creada

    $response = curl_exec($curlHandle);//se ejecuta el POST

    if($response === false){//si la respuesta es falsa, entonces tiene un error
        echo 'Curl error: ' . curl_error($curlHandle);
        die();
    }

    curl_close($curlHandle); //se cierra la consulta de la API
    $response = json_decode($response, true); //se decodifica el JSON que nos devolvió la API en un arreglo

    //var_dump($response['predictions']['0']['probability']);//primera probabilidad
    //var_dump($response['predictions']['0']['tagName']);//primer nombre de la figura
    $figura_azure=$response['predictions']['0']['tagName'];

    $figura_azure = str_replace('á','a',$figura_azure);
    $figura_azure = str_replace('é','e',$figura_azure);
    $figura_azure = str_replace('í','i',$figura_azure);
    $figura_azure = str_replace('ó','o',$figura_azure);
    $figura_azure = str_replace('ú','u',$figura_azure);

    var_dump($figura_azure);

    $id_student = $_SESSION['id_student'];
    $id_teacher = $_SESSION['tch_id'];
    $id_match_game = $_SESSION['match_id'];
    $id_match_questions_answers = $_SESSION['match_questions_answers_id'];
    $id_detail_correct_answer = $_SESSION['detail_game_correct_answer_id'];
    $detail_only_game = $_SESSION['list_detail_games'];
    $figures = $_SESSION['figures'];
    $id_selected_figure_id = getFigureSelectedId($detail_only_game,$figura_azure);

    include '../../Model/Database/Connection.php';
	include '../../Model/Game/functionsDatabase.php';

    global $conn;
    insertMatchEvent($conn,$id_match_questions_answers,$id_match_game,$id_student,$id_teacher,$id_selected_figure_id,$id_detail_correct_answer);

    //var_dump($figura_azure);

    if($id_selected_figure_id == $id_detail_correct_answer){
        $score++;
        $_SESSION['puntuacion'] = $score; 
        echo"<br>";
        var_dump($score);
    }


    if($quantity_questions == 3){
        updateMatchResult($conn,$id_match_game,$quantity_questions+1,$score);
        $result = finishMatch($conn,$id_match_game);

        var_dump($score);
        //header("Location: noteStudent.php?tipo=aleatorio&puntuacion=$score");
    }else{
        if($quantity_questions == 0){
            insertMatchResult($conn,$id_match_game,$id_teacher,$id_student,$score);
        }else{
            updateMatchResult($conn,$id_match_game,$quantity_questions+1,$score);
        }
        $quantity_questions++;
        $_SESSION['cantidad'] = $quantity_questions; 
        header("Location: ../../View/Student/figuresGame.php");
    }

    function getFigureSelectedId($detail_only_game,$select_figure){
		for($x=0;$x<count($detail_only_game);$x++){
			if($detail_only_game[$x]['dtg_detail'] == $select_figure){
				return $detail_only_game[$x]['dtg_id'];
			}
		}

	}
    
?>