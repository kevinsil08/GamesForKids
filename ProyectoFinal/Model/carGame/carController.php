<?php


// manage client request arduino comands / prolog querys
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_raw = file_get_contents('php://input');
    $request = json_decode($request_raw);
    // $consola = shell_exec ("mode COM7: BAUD = 9600 PARITY = n DATA = 8 STOP = 1 to = off dtr = off rts = off");
    // arduino comands
    if (property_exists($request, 'order')) {
        //  Segun lo que tenga post , procesar la palabra y enviar al puerto serial 
        mD("N");
        sleep(1);
        mD("$request->order");
    }
    // obtain prolog query 
    if (property_exists($request, 'prolog')) {
        $tst = $request->prolog;
        // procces query to prolo g
        $output = `swipl -s laberinto.pl -g "$tst" -t halt`;
        // send response 
        echo $output;
    } else {
        exit;
        echo "Json no recibido";
    }
}
function mD($order){
$comPort = fopen("COM7", "w+");
    $consola = shell_exec ("mode COM7: BAUD = 9600 PARITY = n DATA = 8 STOP = 1 to = off dtr = off rts = off");
    //  Segun lo que tenga post , procesar la palabra y enviar al puerto serial 
    
    If (! $comPort) {
        $status = "Not on";
        echo $status;
    }
    fwrite($comPort, $order );
    fclose($comPort);
    sleep(1);
}


