<?php
	function NoExiste($cnn,$correo,$nombre,$apellido)
	{
		$lbien=true;
		$sql = "SELECT * FROM administrator WHERE adm_email='$correo' OR adm_name='$nombre' AND adm_last_name='$apellido';";
		$result = mysqli_query($cnn,$sql);

		if(mysqli_num_rows($result) > 0){
			$lbien=false;
		}

		return true;
	}

	function insertAdmin($cnn, $name, $last_name, $email, $password){

	    $sql = "INSERT INTO administrator(`adm_name`, `adm_last_name`, `adm_email`, `adm_password`) VALUES('$name', '$last_name', '$email', '$password');";
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

	function selectLastAdmin($cnn,$password,$email){
		//$md5pass = md5($password);
	    $sql = "SELECT * FROM administrator WHERE adm_password='$password' AND adm_email='$email'";
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

	function loginAdmin($cnn, $email, $password){
		//$md5pass = md5($password);
		$sql = "SELECT * FROM `administrator` WHERE adm_email='$email' AND adm_password='$password'";
		$rs = mysqli_query($cnn,$sql);
		$fila = mysqli_fetch_assoc($rs);
		return $fila;
	    
	}

//----------------------------------------------------------------------------------------------------------
//Profesor
	function NoExisteTch($cnn,$correo,$nombre,$apellido)
	{
		$lbien=true;
		$sql = "SELECT * FROM teacher WHERE tch_email='$correo' OR tch_name='$nombre' AND tch_last_name='$apellido';";
		$result = mysqli_query($cnn,$sql);

		if(mysqli_num_rows($result) > 0){
			$lbien=false;
		}

		return $lbien;
	}

	function loginTch($cnn, $email, $password){
		//$md5pass = md5($password);
		$sql = "SELECT * FROM `teacher` WHERE tch_email='$email' AND tch_password='$password'";
		$result = mysqli_query($cnn , $sql);
	    if (mysqli_num_rows($result) > 0) {
	        $teacher = mysqli_fetch_assoc($result);
	        return $teacher;
	    }
	    
	}

	function insertTch($cnn, $name, $last_name, $email, $password){

	    $sql = "INSERT INTO teacher(`tch_name`, `tch_last_name`, `tch_email`, `tch_password`) VALUES('$name', '$last_name','$email', '$password');";
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

	function selectLastTch($cnn,$password,$email){
		//$md5pass = md5($password);
	    $sql = "SELECT * FROM teacher WHERE tch_password='$password' AND tch_email='$email'";
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

//-------------------------------------------------------------------------------------------------------
//estudiante
function loginStd($cnn, $nombre, $id){
	$sql = "SELECT * FROM `student` WHERE std_name='$nombre' AND std_id='$id'";
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

?>