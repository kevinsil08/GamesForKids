<?php
    session_start();

    $principal_path= '../../View/Admin/dashboardAdmin.php'; //PATH del dashboard del Administrador

    if(!isset($_POST['id'])){ //Se verifica si ha sido enviado en el _POST['id'] y tiene algún valor
        header("Location: ../../index.php");
        exit();
    }

    include '../Database/Connection.php';
    include 'functionsDatabase.php';

    //Se obtiene los datos del formulario enviado
    $name = $_POST['txtNombre'];
    $last_name = $_POST['txtApellido'];
    $email = $_POST['txtEmail'];
    $id_admin = $_POST['id'];
    $passwd = $_POST['txtpasswd'];

    global $conn;
    
    $verificar = updateAdmin($conn, $id_admin, $name, $last_name,$passwd,$email);//Se actualiza el administrador
    if($verificar === true ){ //Si es 'verdad' manda como parámetro 'mensaje=actualizado', lo que significa que está todo correcto
        header("Location: $principal_path?mensaje=actualizado");
    }else{//Entonces manda como parámetro 'mensaje=error', lo que significa que hubo un error
        header("Location: $principal_path?mensaje=error");
        exit();
    }
?>