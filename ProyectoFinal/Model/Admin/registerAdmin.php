<?php
    session_start();
    $principal_path= '../../View/Admin/dashboardAdmin.php';
    $secundary_path= '../../View/Admin/loginAdmin.php';

    if($_POST['codigo'] != 2121){
        header("Location: $secundary_path?mensaje=contra");
        exit();
    }
    include '../Database/Connection.php';
    include '../Database/Funciones.php';

    $name = $_POST['nombre'];
    $last_name = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['pass'];

    global $conn;
        //$Noexiste = NoExiste($conn,$email,$name,$last_name);
        /*if($NoExiste==true)
        {*/
            //$md5pass = md5($password);
            $verificar = insertAdmin($conn, $name, $last_name, $email, $password);
            if($verificar==true){
                $admin = selectLastAdmin($conn,$password,$email);
                $_SESSION["admin_id"] = $admin['adm_id'];
                header("Location: $principal_path?mensaje=registrado");
            }else{
                header("Location: $secundary_path?mensaje=error");
                exit();
            }
        /*}
        else{
            header("Location: $secundary_path?mensaje=error");
            exit();
        }*/
        
?>