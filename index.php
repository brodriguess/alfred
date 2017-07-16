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
    if ($update["result"]["action"] == "moeda") {
        $array = moeda($update);
        sendMessage($array);
    }else if ($update["result"]["action"] == "piada") {
        $array = piada($update);
        sendMessage($array);
    }else if ($update["result"]["action"] == "tempo") {
        $array = tempo($update);
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

