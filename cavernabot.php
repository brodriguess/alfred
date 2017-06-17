<?php
/*
 * DEFINE TOKEN E API
 */
define('BOT_TOKEN', '347712677:AAEaX0w4Hmc2oR_QY3911_YF8ixSX8mV2y8');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');

function processaMensagem($message, $alfred) {
    $idchat = $destino = $message['chat']['id'];
    $iduser = $message['from']['id'];
    $user = $message['from']['first_name'];
    $msg = $message['text'];
    $private = ($message['chat']['type'] == "private") ? true : false;
    $sintaxe = preg_split("/\s+/", strtolower($msg), 2);
    $comando = substr(str_ireplace("@cavernabot", "", $sintaxe[0]), 1);
    $criterio = $sintaxe[1];
    $image = null;

    if ($comando == "perguntasf" || $comando == "faq") {
        $mensagem = "<b>O que são ChatBots?</b>\nChatbot (ou chatterbot) é um programa de computador que tenta simular um ser humano na conversação com as pessoas. O objetivo é responder as perguntas de tal forma que as pessoas tenham a impressão de estar conversando com outra pessoa e não com um programa de computador. Após o envio de perguntas em linguagem natural, o programa consulta uma base de conhecimento e em seguida fornece uma resposta que tenta imitar o comportamento humano. (<a href='https://pt.wikipedia.org/wiki/Chatterbot'>Wikipedia</a>) ";
    }
    if ($comando == "link" || $comando == "linksuteis") {
        $mensagem = "<b>LINKS ÚTEIS:</b>\nComunidade no Medium:\nhttps://medium.com/botsbrasil\nLista de bots brasileiros:\nhttp://www.botsbrasil.com.br/\nFormulário para adicionar um chatbot na lista do Bots Brasil:\nhttps://botsbrasil.typeform.com/to/Y4fLU8\nNão sabe o que é chatbot?\nhttps://medium.com/botsbrasil/o-que-%C3%A9-um-chatbot-7fa2897eac5d#.yuq1q9v0s\nSe quiser participar da comunidade do ChatBot Brasil é só entrar no grupo:\nhttps://www.facebook.com/groups/chatbotbrasil/?fref=ts \nChatbot Pernambuco:\nhttps://www.facebook.com/groups/247260785715123/\n\nCríticas e sugestões serão sempre bem vindas e faz a comunidade evoluir.\nQualquer dúvida é só falar.";
    }

    if ($alfred == true) {
        $time = date("H", strtotime('-3 hours'));
        if ($time < "12") {
            $periodo = 'manhã';
        } else if ($time >= "12" && $time < "18") {
            $periodo = 'tarde';
        } else if ($time >= "18") {
            $periodo = 'noite';
        }
        $palavras = preg_split("/\s+/./", $criterio);
        $intent = array_values(preg_grep("(^piada(.)?$|^batman(.)?$|^bat-man(.)?$|^profissão(.)?$|^futebol(.)?$|^time(.)?$|^raiz(.)?$|^quadrada(.)?$|^d(o|ó|ó)lar(.)?$|^euro(.)?$|^hora(.)?$|^data(.)?$|^alfred(.)?$)", $palavras));
        
        /*
         * HORA 
         * @bgastaldi
         */
        if (substr($intent[0], 0, 4) == 'hora') {
            $mensagem = "Patrão {$user}, agora são ".date("H:i:s",strtotime('-3 hours'));
        }elseif (substr($intent[0], 0, 4) == 'data') {
            $mensagem = "Patrão {$user}, hoje é dia ".date("d/m/Y",strtotime('-3 hours'));
        }else if (substr($intent[0], 0, 5) == 'piada') {
            /*
             * PIADAS DINAMICAS 
             * @bgastaldi
             */
            $return = getPage('http://aspiadas.com/randomjoke.php');
            preg_match_all('/<p>(([^.]|.)*?)<\/p>/', str_replace("<br />", "", utf8_encode($return)), $matches);
            $mensagem = (isset($matches[1][0])) ? $matches[1][0] : "Desculpe patrão {$user}, hoje não estou conseguindo contar piadas...";
        } else if (substr(strtolower($intent[0]), 0, 4) == 'euro' || substr(strtolower($intent[0]), 0, 5) == 'dolar' || substr($intent[0], 0, 3) == 'usd' || substr(strtolower($intent[0]), 0, 7) == 'dólar') {
            /*
             * COTACAO DO DOLAR
             * @bgastaldi
             */
            $moeda = (substr(strtolower($intent[0]), 0, 4) == 'euro') ? 'EUR' : 'USD';
            $dolar = json_decode(getPage('http://api.promasters.net.br/cotacao/v1/valores?moedas='.$moeda.'&alt=json'), true);
            $mensagem = isset($dolar['valores'][$moeda]['valor']) ? "Patrão {$user}, o valor do ".$intent[0]." agora é R$ " . number_format($dolar['valores'][$moeda]['valor'], 2, ',', '.') . "." : "Desculpe patrão {$user}, ainda não li o jornal hoje!";
        } else if (substr(strtolower($intent[0]), 0, 6) == 'batman' || substr($intent[0], 0, 7) == 'bat-man') {
            $mensagem = "Não conheço nenhum Batman. Apenas trabalho aqui.";
        } else if (substr(strtolower($intent[0]), 0, 4) == 'time' || substr($intent[0], 0, 7) == 'futebol') {
            $mensagem = "Não curto futebol, mas gosto do Gotham F.C.";
        } else if (substr(strtolower($intent[0]), 0, 4) == 'raiz' || substr($intent[1], 0, 7) == 'quadrada') {
            $numero = array_values(preg_grep("/^[0-9]+(.)?$/", $palavras));
            $mensagem = "A raiz quadrada de " . $numero[0] . " é " . sqrt($numero[0]);
        } else if (substr(strtolower($intent[0]), 0, 9) == 'profissão') {
            $mensagem = "Sou mordomo";
        } else if (strpos(strtolower($msg), 'boa noite') !== false) {
            if ($periodo == 'noite') {
                $mensagem = "Boa noite, patrão {$user}.";
            } else {
                $mensagem = "Mas está de {$periodo}, patrão {$user}";
            }
        } else if (strpos(strtolower($msg), 'boa tarde') !== false) {
            if ($periodo == 'tarde') {
                $mensagem = "Boa tarde, patrão {$user}.";
            } else {
                $mensagem = "Mas está de {$periodo}, patrão {$user}";
            }
        } else if (strpos(strtolower($msg), 'bom dia') !== false) {
            if ($periodo == 'manhã') {
                $mensagem = "Bom dia, patrão {$user}.";
            } else {
                $mensagem = "Mas está de {$periodo}, patrão {$user}";
            }
        } else if (strpos(strtolower($msg), 'que horas são') !== false) {
            $mensagem = "São " . $time . " e " . date('i') . ", patrão {$user}";
        } else if (strpos(strtolower($msg), 'melhor bot') !== false) {
            $mensagem = "Melhor bot? Eu.";
        } else if (strpos(strtolower($msg), 'tempo em') !== false or strpos(strtolower($msg), 'tempo para') !== false) {
            /*
             * TEMPO
             * @bgastaldi
             */
            $txt = (strpos(strtolower($msg), 'tempo em') !== false) ? "em" : "para";
            $city = preg_replace('/.*'.$txt.' ([^<]*).*/','$1',$msg);
            $temp = json_decode(getPage('http://api.openweathermap.org/data/2.5/weather?appid=e18cec2f10e6363e05aa8c43b4ae662a&units=metric&q='.$city.',br'), true);
            $mensagem = (isset($temp['main']['temp']) and isset($temp['sys']['country']) and $temp['sys']['country'] == "BR") ? "Patrão {$user}, a temperatura em ".$city." está ".$temp['main']['temp']." °C" : "Desculpe patrão {$user}, não sei a onde fica essa cidade";
        } else if (strpos(strtolower($msg), 'manda nude') !== false) {
            $image = "http://i.imgur.com/8q3GqXL.jpg";
        } else if (strtolower($intent[0]) == 'alfred') {
            $mensagem = "Pois não, patrão {$user}.";
        } else if ($intent[0] != '') {
            $mensagem = "Não entendi, patrão {$user}.";
        }
    }
    $replymarkup = false;
    if(!empty($image)){
        enviaResposta("sendPhoto", array('chat_id' => $destino, 'photo' => $image));
    }else if ($mensagem != "") {
        if ($replymarkup) {
            enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $destino, 'disable_web_page_preview' => true, 'text' => $mensagem, 'reply_markup' => $replymarkup));
        } else {
            enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $destino, 'disable_web_page_preview' => true, 'text' => $mensagem));
        }
    }
}

/*
 * GET PAGE
 */

function getPage($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_ENCODING, "utf8");
    curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/*
 * FUNCAO ENVIAR RESPOSTA
 */

function enviaResposta($metodo, $parametros) {
    $opcoes = array(
        'http' => array(
            'method' => 'POST',
            'content' => json_encode($parametros),
            'header' => "Content-Type: application/json\r\n" .
            "Accept: application/json\r\n"
        )
    );
    $contexto = stream_context_create($opcoes);
    file_get_contents(API_URL . $metodo, false, $contexto);
}

/*
 * RECEBE UPDATES
 */
$update_response = file_get_contents("php://input");
$update = json_decode($update_response, true);

/*
 * VERIFICA SE FOI SOLICITADO CALLBACK QUERY OU REQUISICAO NORMAL
 */
if (isset($update['callback_query'])) {
    processaCallbackQuery($update['callback_query']);
}

/*
 * ATIVANDO O BOT
 */
$alfred = (strpos(strtolower($update['message']['text']), strtolower('alfred')) !== false) ? true : false;

if (isset($update['message']['text']) && (substr($update['message']['text'], 0, 1) == '/' || $alfred/* substr(strtolower($update['message']['text']),0,6) == 'alfred' */)) {
    processaMensagem($update['message'], $alfred);
}
if (isset($update['message']['new_chat_member'])) {
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $update['message']['chat']['id'], 'disable_web_page_preview' => true, 'text' => "Seja bem-vindo, patrão <b>{$update['message']['new_chat_member']['first_name']}</b> sinta-se a vontade. Aqui você pode falar de assuntos relacionados a: ChatBots, PLN, IA, Facebook Messenger, Slack, Telegram...\nCríticas e sugestões serão sempre bem vindas e faz a comunidade evoluir. Qualquer dúvida é só falar."));
}
/*
 * MENSAGEM PARA SITE
 */
echo "Você precisa usar o Telegram para ver este App!";
