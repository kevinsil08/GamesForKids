<?php
    session_start();//abre la sesión  
    $principal_path= '../../View/Admin/dashboardAdmin.php';//PATH donde está el dashboard del Administrador
    $secundary_path= '../../View/Admin/loginAdmin.php';//PATH del login del Administrador

    //Se inicializa las variables
    $id=null;
    $email = $_POST['user'];
    $passwordUser = $_POST['pass'];
    $verificar=null;

    include '../Database/Connection.php';
    include '../Database/Funciones.php';
    global $conn; //Variable de conexión

    /*
    Se llama a la DB con el email y la contraseña.
    Y esa respuesta de la DB se guarda en la variable verificar
    */
    $verificar = loginAdmin($conn, $email, $passwordUser);

    //$md5pass = md5($passwordUser);
    if($verificar['adm_email'] == $email && $verificar['adm_password'] == $passwordUser){ //Se compara si los datos ingresados pertenecen a un usuario
        $_SESSION["admin_id"] = $verificar['adm_id'];
        header("Location: $principal_path");
    }else{//Si no es igual entonces se redirige al $secundary_path con el parámetro 'mensaje=error'
        header("Location: $secundary_path?mensaje=error");
        exit();
    }
?>