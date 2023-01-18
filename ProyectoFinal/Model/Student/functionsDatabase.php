<?php

function listStudents($cnn,$id_teacher){
    $sql = "CALL `pr_list_students`($id_teacher)";
    
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

function insertStudent($cnn, $name, $last_name,$passwd,$email,$date_birth,$sex_student,$id_teacher){

    $sql = "CALL `pr_insert_student`('$name', '$last_name','$passwd','$email','$date_birth','$sex_student', $id_teacher);";
    
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

function selectStudent($cnn, $id_student){

    $sql = "CALL `pr_select_student`($id_student);";
    do
	if($result=mysqli_store_result($cnn)){
		mysqli_free_result($result);
    } while(mysqli_more_results($cnn) && mysqli_next_result($cnn));

    $result = mysqli_query($cnn , $sql);
    if (mysqli_num_rows($result) > 0) {
        $fila = mysqli_fetch_assoc($result);
        return $fila;
        
    }
    
}

function updateStudent($cnn, $id_student, $name,$last_name,$passwd,$email,$date_birth,$sex_student){

    $sql = "CALL `pr_update_student`($id_student, '$name', '$last_name','$passwd','$email','$date_birth','$sex_student');";
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

function deleteStudent($cnn, $id_student){

    $sql = "CALL `pr_delete_student`($id_student);";
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