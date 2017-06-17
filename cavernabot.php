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
         * SALVANDO O LOG
         */
        //logRobots("log.txt", $msg);
        /*
         * INTENTS
         */
        $palavras = preg_split("/\s|(?<=\w)(?=[.,:;!?)])|(?<=[.,!()?\x{201C}])/u", removeAC($criterio), -1, PREG_SPLIT_NO_EMPTY);
        $intent = array_values(preg_grep("(^piada(.)?$|^batman(.)?$|^bat-man(.)?$|^profiss(a|ã)o(.)?$|^futebol(.)?$|^time(.)?$|^raiz(.)?$|^quadrada(.)?$|^d(o|ó|ó)lar(.)?$|^euro(.)?$|^hora(.)?$|^data(.)?$|^alfred(.)?$)", $palavras));

        /*
         * AÇÕES
         */
        if (substr($intent[0], 0, 4) == 'hora') {
            /*
             * HORA
             */
            $hora = date("H:i:s", strtotime('-3 hours'));
            $arrayMensagem = array(
                "Patrão {$user}, agora são {$hora}",
                "São {$hora}, patrão {$user}",
                "Claro! Agora são {$hora}, patrão {$user}"
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } elseif (substr($intent[0], 0, 4) == 'data') {
            /*
             * DATA
             */
            $data = date("d/m/Y", strtotime('-3 hours'));
            $arrayMensagem = array(
                "Patrão {$user}, hoje é dia {$data}",
                "É dia {$data}, patrão {$user}",
                "Dia {$data}, patrão {$user}"
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (substr($intent[0], 0, 5) == 'piada') {
            /*
             * PIADAS DINAMICAS 
             */
            if (strpos(strtolower(removeAC($msg)), "nao") !== false or strpos(strtolower(removeAC($msg)), "não") !== false) {
                $arrayMensagem = array(
                    "OK patrão {$user}, não vou contar",
                    "Claro patrão {$user}, se precisar de alguma coisa me avise",
                    "Hum, não está gostando das minhas piadas?! Desculpe patrão {$user}"
                );
                $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
            } else {
                $return = getPage('http://aspiadas.com/randomjoke.php');
                preg_match_all('/<p>(([^.]|.)*?)<\/p>/', str_replace("<br />", "", utf8_encode($return)), $matches);
                $mensagem = (isset($matches[1][0])) ? $matches[1][0] : "Desculpe patrão {$user}, hoje não estou conseguindo contar piadas...";
            }
        } else if (substr(strtolower($intent[0]), 0, 4) == 'euro' || substr(strtolower($intent[0]), 0, 5) == 'dolar') {
            /*
             * COTACAO DO DOLAR
             */
            $moeda = (substr(strtolower($intent[0]), 0, 4) == 'euro') ? 'EUR' : 'USD';
            $dolar = json_decode(getPage('http://api.promasters.net.br/cotacao/v1/valores?moedas=' . $moeda . '&alt=json'), true);
            if (isset($dolar['valores'][$moeda]['valor'])) {
                $arrayMensagem = array(
                    "Patrão {$user}, o valor do " . $intent[0] . " agora é R$ " . number_format($dolar['valores'][$moeda]['valor'], 2, ',', '.') . ". Tá caro né?",
                    "O valor do " . $intent[0] . " agora é R$ " . number_format($dolar['valores'][$moeda]['valor'], 2, ',', '.') . ". Você vai viajar patrão {$user}?",
                    "O " . $intent[0] . " está em R$ " . number_format($dolar['valores'][$moeda]['valor'], 2, ',', '.') . ". Bora comprar umas muambas patrão {$user}?",
                );
                $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
            } else {
                $mensagem = "Desculpe patrão {$user}, ainda não li o jornal hoje!";
            }
        } else if (substr(strtolower($intent[0]), 0, 6) == 'batman' || substr($intent[0], 0, 7) == 'bat-man') {
            /*
             * BATMAN
             */
            $arrayMensagem = array(
                "Não conheço nenhum Batman. Apenas trabalho aqui.",
                "Quem é o Batman?! Não conheço.",
                "Não sei patrão {$user}."
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (substr(strtolower($intent[0]), 0, 4) == 'time' || substr($intent[0], 0, 7) == 'futebol') {
            $arrayMensagem = array(
                "Não curto futebol, mas gosto do Gotham F.C.",
                "Gotham F.C.",
                "Gotham F.C. e você ?"
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (substr(strtolower($intent[0]), 0, 4) == 'raiz' || substr($intent[1], 0, 7) == 'quadrada') {
            $numero = array_values(preg_grep("/^[0-9]+(.)?$/", $palavras));
            $mensagem = "A raiz quadrada de " . $numero[0] . " é " . sqrt($numero[0]);
        } else if (substr(strtolower(removeAC($intent[0]), 0, 9)) == 'profissão') {
            $arrayMensagem = array(
                "Sou BotMordomo",
                "BotMordomo e você?",
                "BotMordomo! Legal né?"
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (strpos(strtolower($msg), 'boa noite') !== false) {
            $mensagem = ($periodo == 'noite') ? "Boa noite, patrão {$user}." : "Mas está de {$periodo}, patrão {$user}";
        } else if (strpos(strtolower($msg), 'boa tarde') !== false) {
            $mensagem = ($periodo == 'tarde') ? "Boa tarde, patrão {$user}." : "Mas está de {$periodo}, patrão {$user}";
        } else if (strpos(strtolower($msg), 'bom dia') !== false) {
            $mensagem = ($periodo == 'manhã') ? "Bom dia, patrão {$user}." : "Mas está de {$periodo}, patrão {$user}";
        } else if (strpos(strtolower($msg), 'melhor bot') !== false) {
            $arrayMensagem = array(
                "Sou eu! Você conhece outro?",
                "BotMordomo! :)",
                "Quem você acha?! Eu"
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (strpos(strtolower($msg), 'tempo em') !== false or strpos(strtolower($msg), 'tempo para') !== false) {
            /*
             * PREVISÃO DO TEMPO (API)
             */
            $txt = (strpos(strtolower($msg), 'tempo em') !== false) ? "em" : "para";
            $city = preg_replace('/.*' . $txt . ' ([^<]*).*/', '$1', $msg);
            $temp = json_decode(getPage('http://api.openweathermap.org/data/2.5/weather?appid=e18cec2f10e6363e05aa8c43b4ae662a&units=metric&q=' . $city . ',br'), true);
            $mensagem = (isset($temp['main']['temp']) and isset($temp['sys']['country']) and $temp['sys']['country'] == "BR") ? "Patrão {$user}, a temperatura em " . $city . " está " . $temp['main']['temp'] . " °C" : "Desculpe patrão {$user}, não sei a onde fica essa cidade";
        } else if (strpos(strtolower($msg), 'manda nude') !== false or strpos(strtolower($msg), 'nude') !== false or strpos(strtolower($msg), 'nudes') !== false) {
            /*
             * IMAGENS
             */
            $arrayMensagem = array(
                "http://oi64.tinypic.com/2dgrx3p.jpg",
                "http://oi66.tinypic.com/2hmep77.jpg",
                "http://oi66.tinypic.com/2usfthf.jpg",
            );
            $image = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (strpos(strtolower($msg), 'nacionalidade') !== false) {
            $arrayMensagem = array(
                "Sou Brasileiro!",
                "Brasileiro e você?",
                "Brasileiro!"
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (strpos(strtolower($msg), 'idade') !== false) {
            $arrayMensagem = array(
                "Tenho 20! Eu acho!",
                "20 anos. E você?",
                "Acho que 20 anos"
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (strpos(strtolower($msg), 'repositório') !== false or strpos(strtolower($msg), 'repositorio') !== false) {
            $arrayMensagem = array(
                "Segue Patrão {$user}, https://github.com/brodriguess/alfred",
                "Aqui está patrão {$user}, https://github.com/brodriguess/alfred"
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if (strpos(strtolower($msg)) == 'alfred') {
            $arrayMensagem = array(
                "Pois não, patrão {$user}.",
                "Estou aqui, patrão {$user}.",
                "Pode falar, patrão {$user}.",
            );
            $mensagem = $arrayMensagem[array_rand($arrayMensagem, 1)];
        } else if ($intent[0] != '') {
            $mensagem = "Não entendi, patrão {$user}.";
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
