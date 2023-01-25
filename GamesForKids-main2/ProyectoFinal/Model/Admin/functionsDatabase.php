<?php

/*
    Selecciona todas las columnas del Administrador
    $cnn es la variable de la conexión
    $id_admin es la variable que identifica al administrador que está en esa sesión
*/
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

/*
    Actualiza todas las columnas menos la del 'id' del Administrador
    $cnn -> variable de la conexión
    $name -> Nombre del Administrador
    $last_name -> Apellido del Administrador
    $passwd -> Contraseña del Administrador
    $email -> Correo del Administrador
    $id_admin -> variable que identifica al administrador que está en esa sesión
*/
function updateAdmin($cnn, $id_admin, $name, $last_name,$passwd,$email){

    $sql = "CALL `pr_update_admin`('$name', '$last_name','$email','$passwd',$id_admin);";
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
