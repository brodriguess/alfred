<?php


function dolar()
{
    $dolar = json_decode(file_get_contents('http://api.promasters.net.br/cotacao/v1/valores?moedas=USD&alt=json'));
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
        'text' => "Patrão {$args['user']}, o dólar hoje está custando:\n".
            'R$ '.$dolar->valores->USD->valor
    ));
}

function euro()
{
    $euro = json_decode(file_get_contents('http://api.promasters.net.br/cotacao/v1/valores?moedas=EUR&alt=json'));
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
        'text' => "Patrão {$args['user']}, o euro hoje está custando:\n".
            'R$ '.$euro->valores->EUR->valor
    ));
}
