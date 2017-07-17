/*
 * PROCESSANDO A MENSAGEM 
 * QUE CHEGA DO BOT
 */
function processMessage($update) {
    if($update["result"]["action"] == "moeda){
        sendMessage(array(
            "source" => $update["result"]["source"],
            "speech" => "..........TEXT HERE...........",
            "displayText" => ".........TEXT HERE...........",
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
