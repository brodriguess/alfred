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
        'tempo_em',
        'bitcoin',
        'megasena',
	'dolar',
	'euro'
    ];
}

function alfred($args = array())
{
    $arrayMensagem = array(
        "Pois não, patrão {$args['user']}.",
        "Estou aqui, patrão {$args['user']}.",
        "Pode falar, patrão {$args['user']}.",
        "Ao seu dispor, patrão {$args['user']}.",
    );
    
    if ($intent[0] != '') {
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => "Não entendi, patrão {$args['user']}."));
        return;
    }
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function dolar($args = array())
{
    $dolar = json_decode(getPage('http://api.promasters.net.br/cotacao/v1/valores?moedas=USD&alt=json'), true);
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
        'text' => "Patrão {$args['user']}, o dólar hoje está custando R$ ".number_format($dolar['valores']['USD']['valor'], 2, ',', '.')
    ));
}

function euro($args = array())
{
    $euro = json_decode(getPage('http://api.promasters.net.br/cotacao/v1/valores?moedas=EUR&alt=json'), true);
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
        'text' => "Patrão {$args['user']}, o euro hoje está custando R$ ".number_format($euro['valores']['EUR']['valor'], 2, ',', '.')
    ));
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
        "Brasileiro!",
        "Brazilian boy"
    );
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function idade($args = array())
{
    $arrayMensagem = array(
        "Tenho 74! Eu acho!",
        "Acho que 74 anos",
        "74 anos de muita sabedoria"
    );
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true, 'text' => $arrayMensagem[array_rand($arrayMensagem, 1)]));
}

function repositorio($args = array())
{
    $arrayMensagem = array(
        "Patrão {$args['user']}, você pode me programar aqui https://github.com/brodriguess/alfred",
        "Aqui está patrão {$args['user']}, me programe aqui https://github.com/brodriguess/alfred"
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
    if (date('H') > 5 && date('H') < 12)
        return 'manhã';
    if (date('H') >= 12 && date('H') < 18)
        return 'tarde';
    if ((date('H') >= 18 && date('H') <= 23) || (date('H') >= 0 && date('H') <= 5))
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
    $t = array(
        'broken clouds' => 'nuvens quebradas',
        'moderate rain' => 'chuva moderada',
        'few clouds' => 'poucas nuvens',
        'sky is clear' => 'céu limpo',
        'overcast clouds' => 'nuvens nubladas',
        'scattered clouds' => 'nuvens dispersas',
    );
    
    $txt = (strpos(strtolower($args['msg']), 'tempo em') !== false) ? "em" : "para";
    $city = preg_replace('/.*' . $txt . ' ([^<]*).*/', '$1', $args['msg']);
    $temp = json_decode(getPage('http://api.openweathermap.org/data/2.5/weather?appid=e18cec2f10e6363e05aa8c43b4ae662a&units=metric&q=' . $city . ',br'), true);
    
    if (isset($temp['main']['temp']) and isset($temp['sys']['country']) and ($temp['sys']['country'] == "BR")) {
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
            'text' => "Patrão {$args['user']}, o tempo em " . $city . 
                " está com temperatura de " .
                $temp['main']['temp'] ."°C, a umidade " . $temp['main']['humidity'] . '%, e a velocidade do vento é de ' . $temp['wind']['speed'].'m/s.'
        ));
        return;
    }
    
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
        'text' => "Me perdoe patrão {$args['user']}, não sei a onde fica essa cidade"
    ));
    
}

function piada($args = array())
{
    $return = getPage('http://aspiadas.com/randomjoke.php');
    preg_match_all('/<p>(([^.]|.)*?)<\/p>/', str_replace("<br />", "", utf8_encode($return)), $matches);
    (isset($matches[1][0])) ?
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
            'text' => $matches[1][0]
        )) :
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
            'text' => "Patrão {$args['user']}, desculpe-me, hoje não estou conseguindo contar piadas..."
        ));
}

function bitcoin($args = array())
{
    $bitcoin = json_decode(file_get_contents('https://blockchain.info/pt/ticker'));
    enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
        'text' => "Patrão {$args['user']}, esta é a cotação do bitcoin neste instante:\n".
            $bitcoin->USD->symbol.' '.$bitcoin->USD->sell.", ".
            $bitcoin->EUR->symbol.' '.$bitcoin->EUR->sell.', '.
            $bitcoin->BRL->symbol.' '.$bitcoin->BRL->sell
    ));
}

function megasena($args = array())
{    
	$megasena = json_decode(getPage('http://confiraloterias.com.br/api0/json.php?loteria=megasena&token=z63qK2llgyfJO6a'), true);
	
	if($megasena['resultado_completo'] == 1){
		$ganhadores = (isset($megasena['concurso']['premiacao']['sena']['ganhadores']) and $megasena['concurso']['premiacao']['sena']['ganhadores'] > 0) ?  " teve {$megasena['concurso']['premiacao']['sena']['ganhadores']} ganhadore(s). O Valor pago foi de R$ {$megasena['concurso']['premiacao']['sena']['valor_pago']}." : " não teve nenhum ganhador.";
		enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
			'text' => "Patrão {$args['user']}, o concurso {$megasena['concurso']['numero']} realizado no dia {$megasena['concurso']['data']} {$ganhadores}.\n".
			   "Os números sorteados foram ".implode(",", $megasena['concurso']['dezenas']).".\n".
			   "O próximo concurso será realizado dia {$megasena['proximo_concurso']['data']} com valor acumulado estimado em R$ {$megasena['proximo_concurso']['valor_estimado']}.\n".
			   "A Mega da Virada está acumulada em R$ {$megasena['mega_virada_valor_acumulado']}."
		));
		return;
	}
	
	enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
		'text' => "Patrão {$args['user']}, desculpe-me, não estou conseguindo localizar o resultado da megasena"
	));
}
