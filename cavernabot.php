<?php

/*
 * DEFINE TOKEN E API
 */
define('BOT_TOKEN', '347712677:AAEaX0w4Hmc2oR_QY3911_YF8ixSX8mV2y8');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');

require 'habilidades.php';

function processaMensagem($message, $alfred) {
    $idchat = $destino = $message['chat']['id'];
    $iduser = $message['from']['id'];
    $user = $message['from']['first_name'];
    $msg = $message['text'];
    $private = ($message['chat']['type'] == "private") ? true : false;
    $sintaxe = preg_split("/\s+/", strtolower($msg), 2);
    $comando = substr(str_ireplace("@cavernabot", "", $sintaxe[0]), 1);
    $criterio = removeAC($sintaxe[1]);
    $image = null;
    if ($comando == "perguntasf" || $comando == "faq") {
        $mensagem = "<b>O que são ChatBots?</b>\nChatbot (ou chatterbot) é um programa de computador que tenta simular um ser humano na conversação com as pessoas. O objetivo é responder as perguntas de tal forma que as pessoas tenham a impressão de estar conversando com outra pessoa e não com um programa de computador. Após o envio de perguntas em linguagem natural, o programa consulta uma base de conhecimento e em seguida fornece uma resposta que tenta imitar o comportamento humano. (<a href='https://pt.wikipedia.org/wiki/Chatterbot'>Wikipedia</a>) ";
    }
    if ($comando == "link" || $comando == "linksuteis") {
        $mensagem = "<b>LINKS ÚTEIS:</b>\nComunidade no Medium:\nhttps://medium.com/botsbrasil\nLista de bots brasileiros:\nhttp://www.botsbrasil.com.br/\nFormulário para adicionar um chatbot na lista do Bots Brasil:\nhttps://botsbrasil.typeform.com/to/Y4fLU8\nNão sabe o que é chatbot?\nhttps://medium.com/botsbrasil/o-que-%C3%A9-um-chatbot-7fa2897eac5d#.yuq1q9v0s\nSe quiser participar da comunidade do ChatBot Brasil é só entrar no grupo:\nhttps://www.facebook.com/groups/chatbotbrasil/?fref=ts \nChatbot Pernambuco:\nhttps://www.facebook.com/groups/247260785715123/\n\nCríticas e sugestões serão sempre bem vindas e faz a comunidade evoluir.\nQualquer dúvida é só falar.";
    }
    /*
     * ATIVANDO BOT
     */
    if ($alfred == true) {
        
        /*
         * AÇÕES
         */
 
        if (strpos(strtolower($msg)) == 'alfred') {
            alfred(array('destino' => $destino));
        } 
        
        if (strpos(strtolower($msg), 'dolar') !== false || strpos(strtolower($msg), 'dólar') !== false) {
            dolar(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'euro') !== false) {
            euro(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'melhor bot') !== false) {
            melhor_bot(array('destino' => $destino));
        }
        
        if (strpos(strtolower($msg), 'bom dia') !== false) {
            bom_dia(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'boa tarde') !== false) {
            boa_tarde(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'boa noite') !== false) {
            boa_noite(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'hora') !== false) {
            hora(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'data') !== false) {
            data(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'nacionalidade') !== false) {
            nacionalidade(array('destino' => $destino));
        }
        
        if (strpos(strtolower($msg), ' idade') !== false) {
            idade(array('destino' => $destino));
        }
        
        if (strpos(strtolower($msg), 'repositório') !== false or strpos(strtolower($msg), 'repositorio') !== false) {
            repositorio(array('destino' => $destino));
        }
        
        if (strpos(strtolower($msg), 'manda nude') !== false or strpos(strtolower($msg), 'nude') !== false or strpos(strtolower($msg), 'nudes') !== false) {
            manda_nude(array('destino' => $destino));
        }
        
        if (strpos(strtolower($msg), 'tempo em') !== false or strpos(strtolower($msg), 'tempo para') !== false) {
            tempo_em(array('msg' => $msg, 'destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'piada') !== false) {
            piada(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'bitcoin') !== false) {
            bitcoin(array('destino' => $destino, 'user' => $user));
        }
        
        if (strpos(strtolower($msg), 'megasena') !== false || strpos(strtolower($msg), 'mega sena') !== false) {
            megasena(array('destino' => $destino, 'user' => $user));
        }
        
    }
    $replymarkup = false;
    if (!empty($image)) {
        enviaResposta("sendPhoto", array('chat_id' => $destino, 'photo' => $image));
    } else if ($mensagem != "") {
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
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/*
 * REMOVER ACENTUAÇÃO
 */

function removeAC($string) {
    return preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $string));
}

/*
 * SALVANDO LOG
 */

function logRobots($path, $message) {
    $fp = fopen($path, "a+");
    fwrite($fp, $message . chr(13) . chr(10));
    fclose($fp);
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
 * ATIVANDO O BOT
 */
$alfred = (strpos(strtolower($update['message']['text']), strtolower('alfred')) !== false) ? true : false;
if (isset($update['message']['text']) && (substr($update['message']['text'], 0, 1) == '/' || $alfred/* substr(strtolower($update['message']['text']),0,6) == 'alfred' */)) {
    processaMensagem($update['message'], $alfred);
}
/*
 * WELCOME
 */
if (isset($update['message']['new_chat_member'])) {
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $update['message']['chat']['id'], 'disable_web_page_preview' => true, 'text' => "Seja bem-vindo, patrão <b>{$update['message']['new_chat_member']['first_name']}</b>!"));
}
/*
 * MENSAGEM PARA SITE
 */
echo "Você precisa usar o Telegram para ver este App!";
