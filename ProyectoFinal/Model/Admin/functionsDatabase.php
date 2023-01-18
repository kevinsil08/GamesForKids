<?php

function selectAdmin($cnn, $id_admin){
    $sql = "CALL `pr_select_admin`($id_admin);";
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

function updateAdmin($cnn, $id_teacher, $name, $last_name,$email){

    $sql = "CALL `pr_update_teacher`('$name', '$last_name','$email',$id_teacher);";
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

function listAllStudents($cnn){
    $sql = "CALL `pr_get_all_students`()";
    
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

function listAllTeachers($cnn){
    $sql = "CALL `pr_get_all_teachers`()";
    
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
