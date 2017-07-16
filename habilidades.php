<?php


function moeda($update = array())
{
    $mensagem = array();
    if($update["result"]["parameters"]["moeda"] == "EUR" or $update["result"]["parameters"]["moeda"] == "USD"){
        $SLG = ($update["result"]["parameters"]["moeda"] == "EUR") ? "EURO" : "DÓLAR";
        $moeda = json_decode(file_get_contents('http://api.promasters.net.br/cotacao/v1/valores?moedas={$SLG}&alt=json'), true);
        $mensagem[] = array(
            "type" => 0,
            "speech" => "Patrão, o {$SLG} hoje está custando R$ {$moeda['valores'][$update["result"]["parameters"]["moeda"]]['valor']}"
        );
    }else{
        $bitcoin = json_decode(file_get_contents('https://blockchain.info/pt/ticker'), true);
        $mensagem[] = array(
            "type" => 0,
            "speech" => "Patrão, esta é a cotação do bitcoin neste instante\n {$bitcoin['USD']['symbol']} {$bitcoin['USD']['sell']}, {$bitcoin['EUR']['symbol']} {$bitcoin['EUR']['sell']}, {$bitcoin['BRL']['symbol']} {$bitcoin['BRL']['sell']}."
        );    
    }
    
    $mensagem[] = array(
        "type" => 0,
        "speech" => "Gostaria de realizar uma nova consulta?",
    );
    
    return array(
            "source" => $update["result"]["source"],
            "speech" => $mensagem[0],
            "messages" => $mensagem,
            "displayText" => $mensagem[0],
            "contextOut" => array(
                array(
                    "name" => "ctx-moeda",
                    "lifespan" => 1,
                    "parameters" => array()
                )
            )
        );    
}

/**
 * PREVISÃO DO TEMPO (API)
 **/
function tempo($args = array())
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
    $temp = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/weather?appid=e18cec2f10e6363e05aa8c43b4ae662a&units=metric&q=' . $city . ',br'), true);
    
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
    return = json_decode(file_get_contents('http://aspiadas.com/randomjoke.php'));
    preg_match_all('/<p>(([^.]|.)*?)<\/p>/', str_replace("<br />", "", utf8_encode($return)), $matches);
    (isset($matches[1][0])) ?
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
            'text' => $matches[1][0]
        )) :
        enviaResposta("sendMessage", array('parse_mode' => 'HTML', 'chat_id' => $args['destino'], 'disable_web_page_preview' => true,
            'text' => "Patrão {$args['user']}, desculpe-me, hoje não estou conseguindo contar piadas..."
        ));
}
