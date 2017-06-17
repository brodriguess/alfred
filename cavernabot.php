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
        $palavras = preg_split("/\s+/", $criterio);
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
            $return = 
