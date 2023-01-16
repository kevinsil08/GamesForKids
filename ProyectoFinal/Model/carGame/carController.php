<?php
// manage client request arduino comands / prolog querys
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_raw = file_get_contents('php://input');
    $request = json_decode($request_raw);
    // arduino comands
    if (property_exists($request ,'order')) {
        $comPort = fopen("COM6", "w+");
    //  Segun lo que tenga post , procesar la palabra y enviar al puerto serial 
        if ($request->order == 'DERECHA') {
            fwrite($comPort, "o");
            echo "Luz izq";
        } else {
            fwrite($comPort, "c");
            echo "Luz der";
        }
    }
    // obtain prolog query 
    if (property_exists($request ,'prolog')) {
        $tst = $request -> prolog;
        // procces query to prolo g
        $output = `swipl -s laberinto.pl -g "$tst" -t halt`;
        // send response 
        echo $output ;
    }
    exit;
} else {
    echo "Json no recibido";
}

?>