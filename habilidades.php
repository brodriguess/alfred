<?php

/*
 *  FUNÇÕES
 */

function moeda($update = array()) {
    $mensagem = array();
    if ($update['result']['parameters']['moeda'] == 'EUR' or $update['result']['parameters']['moeda'] == 'USD') {
        $SLG = ($update['result']['parameters']['moeda'] == 'EUR') ? 'EURO' : 'DÓLAR';
        $moeda = json_decode(getPage('http://api.promasters.net.br/cotacao/v1/valores?moedas=' . $update['result']['parameters']['moeda'] . '&alt=json'), true);
        $mensagem[] = array(
            'type' => 0,
            'speech' => 'Patrão, o ' . $SLG . ' hoje está custando R$ ' . $moeda['valores'][$update['result']['parameters']['moeda']]['valor'] . '.'
        );
    } else {
        $bitcoin = json_decode(getPage('https://blockchain.info/pt/ticker'), true);
        $mensagem[] = array(
            'type' => 0,
            'speech' => 'Patrão, esta é a cotação do bitcoin neste instante: ' . $bitcoin['USD']['symbol'] . ' ' . $bitcoin['USD']['sell'] . ', ' . $bitcoin['EUR']['symbol'] . ' ' . $bitcoin['EUR']['sell'] . ', ' . $bitcoin['BRL']['symbol'] . ' ' . $bitcoin['BRL']['sell'] . '.'
        );
    }

    $mensagem[] = array(
        'type' => 0,
        'speech' => 'Gostaria de realizar uma nova consulta?',
    );

    return array(
        'source' => $update['result']['source'],
        'messages' => $mensagem,
        'contextOut' => array(
            array(
                'name' => 'ctx-moeda',
                'lifespan' => 1,
                'parameters' => array()
            )
        )
    );
}

/*
 * PREVISÃO DO TEMPO (API)
 */

function tempo($update = array()) {
    $mensagem = array();
    $t = array(
        'broken clouds' => 'nuvens quebradas',
        'moderate rain' => 'chuva moderada',
        'few clouds' => 'poucas nuvens',
        'sky is clear' => 'céu limpo',
        'overcast clouds' => 'nuvens nubladas',
        'scattered clouds' => 'nuvens dispersas',
    );

    $temp = json_decode(getPage('http://api.openweathermap.org/data/2.5/weather?appid=e18cec2f10e6363e05aa8c43b4ae662a&units=metric&q=' . $update['result']['parameters']['cidade'] . ',br'), true);
    if (isset($temp['main']['temp']) and isset($temp['sys']['country']) and ( $temp['sys']['country'] == 'BR')) {
        $mensagem[] = array(
            'type' => 0,
            'speech' => 'Patrão, o tempo em ' . $update['result']['parameters']['cidade'] . ' está com temperatura de ' .
            $temp['main']['temp'] . '°C, a umidade ' . $temp['main']['humidity'] . '%, e a velocidade do vento é de ' . $temp['wind']['speed'] . 'm/s.'
        );
    } else {
        $mensagem[] = array(
            'type' => 0,
            'speech' => 'Me perdoe patrão, não sei a onde fica essa cidade'
                );
    }

    $mensagem[] = array(
        'type' => 0,
        'speech' => 'Gostaria de saber o tempo em outra cidade?'
    );

    return array(
        'source' => $update['result']['source'],
        'messages' => $mensagem,
        'contextOut' => array(
            array(
                'name' => 'ctx-tempo',
                'lifespan' => 1,
                'parameters' => array()
            )
        )
    );
}

function piada($update = array()) {
    $mensagem = array();
    $piada = getPage('http://aspiadas.com/randomjoke.php');
    preg_match_all('/<p>(([^.]|.)*?)<\/p>/', str_replace("<br />", "", utf8_encode($piada)), $matches);

    if (isset($matches[1][0])) {
        $mensagem[] = array(
            'type' => 0,
            'speech' => $matches[1][0]
        );
        $mensagem[] = array(
            'type' => 0,
            'speech' => 'Gostaria de ler outra piada?',
        );
    } else {
        $mensagem[] = array(
            'type' => 0,
            'speech' => 'Patrão, desculpe-me, hoje não estou conseguindo contar piadas...',
        );
    }

    return array(
        'source' => $update['result']['source'],
        'messages' => $mensagem,
        'contextOut' => array(
            array(
                'name' => 'ctx-piada',
                'lifespan' => 1,
                'parameters' => array()
            )
        )
    );
}

/*
 * FUNÇÃO CURL
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
