<?php

function habilidades() {
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

function alfred() {
    $arrayMensagem = array(
        "Pois não, patrão {$user}.",
        "Estou aqui, patrão {$user}.",
        "Pode falar, patrão {$user}.",
    );
    
    return ($intent[0] != '') ? "Não entendi, patrão {$user}." ? $arrayMensagem[array_rand($arrayMensagem, 1)];
}

function nacionalidade() {
    $arrayMensagem = array(
        "Sou Brasileiro!",
        "Brasileiro e você?",
        "Brasileiro!"
    );
    return $arrayMensagem[array_rand($arrayMensagem, 1)];
}

function idade() {
    $arrayMensagem = array(
        "Tenho 80! Eu acho!",
        "80 anos. E você?",
        "Acho que 80 anos"
    );
    return $arrayMensagem[array_rand($arrayMensagem, 1)];
}

function repositorio() {
    $arrayMensagem = array(
        "Segue Patrão {$user}, https://github.com/brodriguess/alfred",
        "Aqui está patrão {$user}, https://github.com/brodriguess/alfred"
    );
    return $arrayMensagem[array_rand($arrayMensagem, 1)];
}

function manda_nude() {
    $arrayMensagem = array(
        "http://oi64.tinypic.com/2dgrx3p.jpg",
        "http://oi66.tinypic.com/2hmep77.jpg",
        "http://oi66.tinypic.com/2usfthf.jpg",
    );
    return $arrayMensagem[array_rand($arrayMensagem, 1)];
}

function periodo() {
    if (date('H') >= 0 && date('H') < 12)
        return 'manhã';
    if (date('H') >= 12 && date('H') < 18)
        return 'tarde';
    if (date('H') >= 18 && date('H') < 23)
        return 'noite';
}

function bom_dia() {
    return periodo() == 'manhã' ? "Bom dia, patrão {$user}." : "Mas está de {periodo()}, patrão {$user}";
}

function boa_tarde() {
    return periodo() == 'tarde' ? "Boa tarde, patrão {$user}." : "Mas está de {periodo()}, patrão {$user}";
}

function boa_noite() {
    return periodo() == 'noite' ? "Boa noite, patrão {$user}." : "Mas está de {periodo()}, patrão {$user}";
}

