<?php
session_start();
$principal_path= '../../welcome.php';
$secundary_path= 'tch_registro.php';

include '../Database/Connection.php';
include '../Database/Funciones.php';

$name = $_POST['nombre'];
$last_name = $_POST['apellido'];
$email = $_POST['email'];
$password = $_POST['pass'];

global $conn;
    //$Noexiste = NoExisteTch($conn,$email,$name,$last_name);
    //if($NoExiste==true)
    //{
        $md5pass = md5($password);
        $verificar = insertTch($conn, $name, $last_name, $email, $md5pass);
        if($verificar==true){
            $admin = selectLastTch($conn,$password,$email);
            $_SESSION["tch_id"] = $admin['tch_id'];
            header("Location: $principal_path?mensaje=registrado");
        }else{
            header("Location: $secundary_path?mensaje=error");
            exit();
        }
    /*}
    else{
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
    */
?>