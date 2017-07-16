<?php

/*
 * PROCESSANDO A MENSAGEM 
 * QUE CHEGA DO BOT
 */
function processMessage($update) {
    if($update["result"]["action"] == "buscar"){
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "TESTE",
            "displayText" => "TESTE",
            "contextOut" => array()
        ));
    }
}
/*
 * FUNÇÃO PARA ENVIAR A MENSAGEM
 */
function sendMessage($parameters) {
    echo json_encode($parameters);
}
/*
 * PEGANDO A REQUISIÇÃO
 */
$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);
if (isset($update["result"]["action"])) {
    processMessage($update);
}

/*
require 'habilidades.php';

/*
 * PEGANDO A MENSAGEM 
 *
if (isset($update["result"]["action"])) {
    processMessage($update, $platform);
}

/*
 * PROCESSANDO A MENSAGEM 
 *
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
 *
function sendMessage($parameters) {
    echo json_encode($parameters);
}

/*
 * RECEBE UPDATES
 *
$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);
*/
