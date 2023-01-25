<?php 

function listTypeGames($cnn){
    $sql = "CALL `pr_list_type_game`()";
    
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));
    $result = mysqli_query($cnn , $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($fila = mysqli_fetch_assoc($result)) {
            $lista[] = $fila;
        }
        return $lista;
    }else{
        return null;
    }
}

function listDetailGames($cnn,$id_type_game){
    $sql = "CALL `pr_list_detail_games`($id_type_game)";
    
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));
    $result = mysqli_query($cnn , $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($fila = mysqli_fetch_assoc($result)) {
            $lista[] = $fila;
        }
        return $lista;
    }
        return null;
    
}

function insertMatch($cnn, $id_teacher, $id_type_game, $password_generated){

    date_default_timezone_set('America/Guayaquil');
    $date = date('Y-m-d H:i:s');

    $sql = "CALL `pr_create_match_game`($id_teacher, $id_type_game, '$date', '$password_generated');";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    if(!mysqli_query($cnn,$sql)){
        $e = mysqli_error($cnn);
        echo "Error: ".$e;
        return false;
    }
    return $date;
}

function selectLastMatch($cnn,$id_teacher){
    $sql = "CALL `pr_last_match_for_teacher`($id_teacher);";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $match = mysqli_fetch_assoc($result);
        return $match;
    }
    return null;
}

//pr_last_match_for_teacher_with_password

function selectLastMatchWithPassword($cnn,$id_teacher,$passwd){
    $sql = "CALL `pr_last_match_for_teacher_with_password`($id_teacher,'$passwd');";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $match = mysqli_fetch_assoc($result);
        return $match;
    }
    return null;
}

function selectLastMatchRandom($cnn,$id_teacher,$date){
    $sql = "CALL `pr_last_match_for_student`($id_teacher,'$date');";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $match = mysqli_fetch_assoc($result);
        return $match;
    }
    return null;
}

function insertMatchQuestionsAnswers($cnn, $id_match, $id_detail_game_answer,$type_answer){

    $sql = "CALL `pr_insert_match_questions_answers`($id_match, $id_detail_game_answer, '$type_answer');";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    if(!mysqli_query($cnn,$sql)){
        $e = mysqli_error($cnn);
        echo "Error: ".$e;
        return false;
    }
    return true;
}

function selectLastMatchQuestionsAnswers($cnn,$id_match){
    $sql = "CALL `pr_get_last_match_questions_answers`($id_match);";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $match = mysqli_fetch_assoc($result);
        return $match;
    }
    return null;
}

function listMatchQuestionsAnswers($cnn,$id_match_game){
    $sql = "CALL `pr_get_match_questions_answers`($id_match_game)";
    
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));
    $result = mysqli_query($cnn , $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($fila = mysqli_fetch_assoc($result)) {
            $lista[] = $fila;
        }
        return $lista;
    }
        return null;
    
}

function findIdMatch($cnn,$id_teacher,$password_generated){

    $sql = "CALL `pr_find_password_match`($id_teacher,'$password_generated');";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $passwd = mysqli_fetch_assoc($result);
        return $passwd;
    }  
    return null;
}

function insertMatchEvent($cnn,$id_match_questions_answers,$id_match_game,$id_student,$id_teacher,$id_student_answer,$id_detail_correct_answer){

    if($id_student_answer == null){
        $sql = "CALL `pr_insert_match_event`($id_match_questions_answers, $id_match_game, $id_student,$id_teacher,null,$id_detail_correct_answer);";
    }else{
        $sql = "CALL `pr_insert_match_event`($id_match_questions_answers, $id_match_game, $id_student,$id_teacher,$id_student_answer,$id_detail_correct_answer);";
    }

    
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    if(!mysqli_query($cnn,$sql)){
        $e = mysqli_error($cnn);
        echo "Error1: ".$e;
        return false;
    }
    return true;
}

function insertMatchResult($cnn,$id_match_game,$id_teacher,$id_student,$score){

    $sql = "CALL `pr_create_match_result`($id_match_game,$id_teacher,$id_student,$score);";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    if(!mysqli_query($cnn,$sql)){
        $e = mysqli_error($cnn);
        echo "Error: ".$e;
        return false;
    }
    return true;

}

function updateMatchResult($cnn, $id_match_game,$quantity_questions_match,$score){

    $sql = "CALL `pr_update_match_result`($id_match_game,$quantity_questions_match,$score);";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    if(!mysqli_query($cnn,$sql)){
        $e = mysqli_error($cnn);
        echo "Error: ".$e;
        return false;
    }
    return true;
}

function selectMatch($cnn,$id_match){
    $sql = "CALL `pr_select_match`($id_match);";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $match = mysqli_fetch_assoc($result);
        return $match;
    }
    return null;
}

function finishMatch($cnn, $id_match){

    date_default_timezone_set('America/Guayaquil');
    $date = date('Y-m-d H:i:s');

    $sql = "CALL `pr_finish_match`($id_match,'$date');";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    if(!mysqli_query($cnn,$sql)){
        $e = mysqli_error($cnn);
        echo "Error: ".$e;
        return false;
    }
    return true;
}


function get_califications_students_with_dates($cnn,$id_teacher,$first_date,$final_date){
    $sql = "CALL `pr_get_califications_students_with_dates`($id_teacher,'$first_date 00:00:00','$final_date 23:59:59')";
    
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($fila = mysqli_fetch_assoc($result)) {
            $lista[] = $fila;
        }
        return $lista;
    }
        return null;
    
    
}
?>