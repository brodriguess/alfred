<?php

require 'habilidades.php';

/*
 * PEGANDO A MENSAGEM 
 */
if (isset($update["result"]["action"])) {
    processMessage($update, $platform);
}

/*
 * PROCESSANDO A MENSAGEM 
 */
function processMessage($update, $platform) {
    if ($update["result"]["action"] == "dolar.consulta") {
        $array = dolar($update);
        sendMessage($array);
    }else if ($update["result"]["action"] == "contar.piada") {
        $array = dolar($update);
        sendMessage($array);
    }
}


/*
 * FUNÇÃO PARA ENVIAR A MENSAGEM
 */

function sendMessage($parameters) {
    echo json_encode($parameters);
}

/*
 * RECEBE UPDATES
 */
$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);
