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
        $palavras = preg_split("/\s+/", $criterio);
        $intent = array_values(preg_grep("(^piada(.)?$|^batman(.)?$|^bat-man(.)?$|^profissão(.)?$|^futebol(.)?$|^time(.)?$|^raiz(.)?$|^quadrada(.)?$)", $palavras));

        /*
         * PIADAS
         */
        if (substr($intent[0], 0, 5) == 'piada') {
            /*
             * PIADAS DINAMICAS
             */
            $ch = curl_init();
            $timeout = 0;
            curl_setopt($ch, CURLOPT_URL, 'http://aspiadas.com/randomjoke.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_ENCODING ,"utf8");
            $output = curl_exec ($ch);
            curl_close($ch);
            $pattern = '/<p>(([^.]|.)*?)<\/p>/';
            preg_match_all($pattern, str_replace("<br />","\n",utf8_encode($output)), $matches);
            if(isset($matches[1][0])){
               $mensagem = $matches[1][0];
            }else{
                $r = rand(0, 23);
                $piadas = array(
                    "Dois litros de leite atravessaram a rua e foram atropelados. Um morreu, o outro não, por quê?\nPor que um deles era Longa Vida.",
                    "Por que o elefante não pega fogo?\nPorque ele já é cinza.",
                    "Se o cachorro tivesse religião, qual seria?\nCão-domblé.",
                    "O que o cavalo foi fazer no orelhão?\nPassar um trote.",
                    "O que dá o cruzamento de pão, queijo e um macaco?\nX-panzé",
                    "O que o tomate foi fazer no banco?\nFoi tirar extrato.",
                    "O que a galinha foi fazer na igreja?\nAssistir a Missa do Galo.",
                    "Como as enzimas se reproduzem?\nFica uma enzima da outra",
                    "Por que a Coca-Cola e a Fanta se dão muito bem?\nPorque se a Fanta quebra, a Coca-Cola!",
                    "Por que não é bom guardar o quibe no freezer?\nPorque lá dentro ele esfirra.",
                    "Por que as plantas novinhas não falam?\nPorque elas são mudinhas.",
                    "Por que o galo canta de olhos fechados?\nPorque ele já sabe a letra da música de cor",
                    "Por que o Batman colocou o batmóvel no seguro?\nPorque ele tem medo que robin",
                    "Por que Perón não teve filhos?\nPorque sua mulher Evita!",
                    "Como o Batman faz para que abram a bat-caverna?\nEle bat-palma.",
                    "Como se faz omelete de chocolate?\nCom ovos de páscoa.",
                    "Por que na Argentina as vacas vivem olhando pro céu?\nPorque tem 'Boi nos Aires'",
                    "Por que o Maradona não gosta que chamem ele de craque?\nPorque ele prefere cocaína...",
                    "Para que servem óculos verdes?\nPara verde perto...",
                    "Para que servem óculos vermelhos?\nPara vermelhor...",
                    "Para que servem óculos marrons?\nPara ver marromenos...",
                    "Por que a mulher do Hulk divorciou-se dele?\nPorque ela queria um homem mais maduro...",
                    "Por que o jacaré tirou o jacarezinho da escola?\nPorque ele réptil de ano.",
                    "Você sabe qual e o contrário de volátil?\nVem cá sobrinho.",
                    "Como se fala topless em chinês?\nXem-chu-tian."
                );
                $mensagem = $piadas[$r];
            }
        } else if (substr(strtolower($intent[0]), 0, 6) == 'batman' || substr($intent[0], 0, 7) == 'bat-man') {
            $mensagem = "Não conheço nenhum Batman. Apenas trabalho aqui.";
        } else if (substr(strtolower($intent[0]), 0, 4) == 'time' || substr($intent[0], 0, 7) == 'futebol') {
            $mensagem = "Não curto futebol, mas gosto do Gotham F.C.";
        } else if (substr(strtolower($intent[0]), 0, 4) == 'raiz' || substr($intent[1], 0, 7) == 'quadrada') {
            $numero = array_values(preg_grep("/^[+-]?[0-9]$/", $palavras));
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
        } else if ($intent[0] == '') {
            $mensagem = "Pois não, patrão {$user}.";
        } else if ($intent[0] != '') {
            $mensagem = "Não entendi, patrão {$user}.";
        }
        $array = print_r($intent);
        enviaResposta("sendMessage", array('parse_mode' => 'HTML','chat_id' => '220905337','disable_web_page_preview' => true,'text' => $intent . ', ' . $msg));
    }
    $replymarkup = false;
    if ($mensagem != "") {
        if ($replymarkup) {
            enviaResposta("sendMessage", array('parse_mode' => 'HTML','chat_id' => $destino,'disable_web_page_preview' => true,'text' => $mensagem,'reply_markup' => $replymarkup));
        } else {
            enviaResposta("sendMessage", array('parse_mode' => 'HTML','chat_id' => $destino,'disable_web_page_preview' => true,'text' => $mensagem));
        }
    }
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
if (strpos(strtolower($update['message']['text']), strtolower('alfred')) !== false) {
    $alfred = true;
} else {
    $alfred = false;
}
if (isset($update['message']['text']) && (substr($update['message']['text'], 0, 1) == '/' || $alfred/* substr(strtolower($update['message']['text']),0,6) == 'alfred' */)) {
    processaMensagem($update['message'], $alfred);
}
if (isset($update['message']['new_chat_member'])) {
    enviaResposta("sendMessage", array('parse_mode' => 'HTML','chat_id' => $update['message']['chat']['id'],'disable_web_page_preview' => true,'text' => "Seja bem-vindo, patrão <b>{$update['message']['new_chat_member']['first_name']}</b> sinta-se a vontade. Aqui você pode falar de assuntos relacionados a: ChatBots, PLN, IA, Facebook Messenger, Slack, Telegram...\nCríticas e sugestões serão sempre bem vindas e faz a comunidade evoluir. Qualquer dúvida é só falar."));
}
/*
 * MENSAGEM PARA SITE
 */
echo "Você precisa usar o Telegram para ver este App!";
