<?php
$servername = "localhost";
$username = "root";
$password = "3434";
$db = "games_kids";

try{
    
    // Se crea la conexión
    $conn = mysqli_connect($servername , $username , $password , $db);


    if (!$conn) {//Comprueba que la conexión sea exitosa, si no lo es recupera el error del por qué
        die("Conecion fallida : " .mysqli_connect_error());
    }
    
    return $conn;

}catch(Exception $e){
    echo "Problema con la conexi&oacute;n: ".$e->getMessage();//Comprueba que la conexión sea exitosa, si no lo es recupera el error del por qué
}

?>