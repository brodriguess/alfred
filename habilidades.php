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

function melhor_bot($args = array())
{
    $arrayMensagem = array(
        "Sou eu! Você conhece outro?",
        "BotMordomo! :)",
        "Quem você acha?! Eu"
    );
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
    enviaResposta("sendPhoto", array('chat_id' => $args['destino'], 'photo' =>  $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

date_default_timezone_set('America/Bahia');

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
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Mas está de ".periodo().", patrão {$args['user']}"));
}

function boa_tarde($args = array())
{
    if(periodo() == 'tarde') {
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Boa tarde, patrão {$args['user']}."));
        return;
    }
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Mas está de ".periodo().", patrão {$args['user']}"));
}

function boa_noite($args = array())
{
    if(periodo() == 'noite') {
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Boa noite, patrão {$args['user']}."));
        return;
    }
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Mas está de ".periodo().", patrão {$args['user']}"));
}

function hora($args = array())
{
    $hora = date("H:i:s");
    $arrayMensagem = array(
        "Patrão {$args['user']}, agora são {$hora}",
        "São {$hora}, patrão {$args['user']}",
        "Claro! Agora são {$hora}, patrão {$args['user']}"
    );
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function data($args = array())
{
    $data = date("d/m/Y");
    $arrayMensagem = array(
                "Patrão {$args['user']}, hoje é dia {$data}",
                "É dia {$data}, patrão {$args['user']}",
                "Dia {$data}, patrão {$args['user']}"
    );
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

/**
 * PREVISÃO DO TEMPO (API)
 **/
function tempo_em($args = array())
{
    $txt = (strpos(strtolower($msg), 'tempo em') !== false) ? "em" : "para";
    $city = preg_replace('/.*' . $txt . ' ([^<]*).*/', '$1', $msg);
    $temp = json_decode(getPage('http://api.openweathermap.org/data/2.5/weather?appid=e18cec2f10e6363e05aa8c43b4ae662a&units=metric&q=' . $city . ',br'), true);
    
    (isset($temp['main']['temp']) and isset($temp['sys']['country']) and $temp['sys']['country'] == "BR") ?
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
            'text' => "Patrão {$args['user']}, a temperatura em " .
                $city . " estar " . $temp['main']['temp'] . "°C, a humidade " .
                $temp['main']['humidity'] . '%, e a velocidade do vento é de ' . $temp['wind']['speed'].'km/h.'
        )) :
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
            'text' => "Desculpe patrão {$args['user']}, não sei a onde fica essa cidade"
        ));
}
