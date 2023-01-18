<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "games_kids";

try{
    
    // create conection
    $conn = mysqli_connect($servername , $username , $password , $db);
    // check conection procedural

    if (!$conn) {
        die("Conecion fallida : " .mysqli_connect_error());
    }
    
    return $conn;

}catch(Exception $e){
    echo "Problema con la conexi&oacute;n: ".$e->getMessage();
}

?>