<?php

function loginTeacher($cnn, $email_teacher, $password_teacher){

    $sql = "CALL `pr_login_teacher`('$email_teacher', '$password_teacher');";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);

    if (mysqli_num_rows($result) > 0) {
        $fila = mysqli_fetch_assoc($result);
        return $fila;
    }

    return false;
    
}

function insertTeacher($cnn, $name, $last_name, $email, $password_teacher){

    $sql = "CALL `pr_insert_teacher`('$name', '$last_name', '$email', '$password_teacher');";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    if(!mysqli_query($cnn,$sql)){
        $e = mysqli_error($cnn);
        echo "Error: ".$e;
        return false;
    }else{
        return true;
    }
    
}

function selectTeacher($cnn, $id_teacher){
    $sql = "CALL `pr_select_teacher`($id_teacher);";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $teacher = mysqli_fetch_assoc($result);
        return $teacher;
    }
}

function selectLastTeacher($cnn){
    $sql = "CALL `pr_last_teacher_id`();";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $teacher = mysqli_fetch_assoc($result);
        return $teacher;
    }
    return null;
}

function updateTeacher($cnn, $id_teacher, $name, $last_name,$email,$passwd){

    $sql = "CALL `pr_update_teacher`('$name', '$last_name','$email','$passwd',$id_teacher);";
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


?>