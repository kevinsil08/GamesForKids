<?php
    session_start();
    $principal_path= '../../View/Student/dashboard.php';
    $secundary_path= '../../View/Student/loginStudent.php';

    $id=null;
    $nombre = $_POST['user'];
    $codigo = $_POST['pass'];
    $verificar=null;
    

    include '../Database/Connection.php';
    include '../Database/Funciones.php';
    global $conn;

    $verificar = loginStd($conn, $nombre, $codigo);

    var_dump($_POST);
    var_dump($verificar);

    if($verificar['std_name'] == $nombre && $verificar['std_id'] == $codigo){
        $_SESSION["id_student"] = $verificar['std_id'];
        $_SESSION["tch_id"] = $verificar['tch_id'];
        $_SESSION['name_student'] = $verificar['std_name'];
        header("Location: $principal_path");
    }else{
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
?>