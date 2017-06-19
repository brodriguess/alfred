<?php

function habilidades()
{
    return [
        'alfred',
        'nacionalidade',
        'idade',
        'repositorio',
        'manda_nude',
        'bom_dia',
        'boa_tarde',
        'boa_noite',
    ];
}

function alfred($args = array())
{
    $arrayMensagem = array(
        "Pois não, patrão {$args['user']}.",
        "Estou aqui, patrão {$args['user']}.",
        "Pode falar, patrão {$args['user']}.",
    );
    
    if ($intent[0] != '') {
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Não entendi, patrão {$args['user']}."));
        return;
    }
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function nacionalidade($args = array())
{
    $arrayMensagem = array(
        "Sou Brasileiro!",
        //"Brasileiro e você?",
        "Brasileiro!"
    );
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function idade($args = array())
{
    $arrayMensagem = array(
        "Tenho 80! Eu acho!",
        //"80 anos. E você?",
        "Acho que 80 anos"
    );
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function repositorio($args = array())
{
    $arrayMensagem = array(
        "Patrão {$user}, você pode me programar aqui https://github.com/brodriguess/alfred",
        "Aqui está patrão {$user}, escreve aqui https://github.com/brodriguess/alfred"
    );
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function manda_nude($args = array())
{
    $arrayMensagem = array(
        "http://oi64.tinypic.com/2dgrx3p.jpg",
        "http://oi66.tinypic.com/2hmep77.jpg",
        "http://oi66.tinypic.com/2usfthf.jpg",
    );
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function periodo()
{
    if (date('H') >= 0 && date('H') < 12)
        return 'manhã';
    if (date('H') >= 12 && date('H') < 18)
        return 'tarde';
    if (date('H') >= 18 && date('H') <= 23)
        return 'noite';
}

function bom_dia($args = array())
{
    if(periodo() == 'manhã') {
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Bom dia, patrão {$args['user']}."));
        return;
    }
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Mas está de {periodo()}, patrão {$args['user']}"));
}

function boa_tarde($args = array())
{
    return periodo() == 'tarde' ? "Boa tarde, patrão {$user}." : "Mas está de {periodo()}, patrão {$user}";
}

function boa_noite($args = array())
{
    return periodo() == 'noite' ? "Boa noite, patrão {$user}." : "Mas está de {periodo()}, patrão {$user}";
}

