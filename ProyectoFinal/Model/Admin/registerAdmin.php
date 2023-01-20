<?php
    session_start();//abre la sesión  
    $principal_path= '../../View/Admin/dashboardAdmin.php';//PATH donde está el dashboard del Administrador
    $secundary_path= '../../View/Admin/loginAdmin.php';//PATH del login del Administrador

    if($_POST['codigo'] != 2121){//Código único para los administradores
        header("Location: $secundary_path?mensaje=contra"); //Redirige
        exit();
    }
    include '../Database/Connection.php';
    include '../Database/Funciones.php';

    //Se inicializan las variables
    $name = $_POST['nombre'];
    $last_name = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['pass'];

    global $conn;
        //$Noexiste = NoExiste($conn,$email,$name,$last_name);
        /*if($NoExiste==true)
        {*/
            //$md5pass = md5($password);



            /*
                Se trata de insertar un administrador con los datos del formulario
                Si se insertó correctamente te regresa un 'true' 
                Si no se insertó te regresa un 'false'
            */
            $verificar = insertAdmin($conn, $name, $last_name, $email, $password);
            if($verificar == true){

                $admin = selectLastAdmin($conn,$password,$email);
                $_SESSION["admin_id"] = $admin['adm_id'];
                header("Location: $principal_path?mensaje=registrado");

            }else{//Si no es igual a 'true' existió un error en la DB entonces se redirige al $secundary_path con el parámetro 'mensaje=error'
                header("Location: $secundary_path?mensaje=error");
                exit();
            }
        /*}
        else{
            header("Location: $secundary_path?mensaje=error");
            exit();
        }*/
        
?>