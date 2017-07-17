/*
 *  FUNÇÕES
 */

function moeda($update = array()) {
    $mensagem = array();
    if ($update['result']['parameters']['moeda'] == 'EUR' or $update['result']['parameters']['moeda'] == 'USD') {
        $SLG = ($update['result']['parameters']['moeda'] == 'EUR') ? 'EURO' : 'DÓLAR';
        $moeda = json_decode(file_get_contents('http://api.promasters.net.br/cotacao/v1/valores?moedas=' . $update['result']['parameters']['moeda'] . '&alt=json'), true);
        $mensagem[] = array(
            'type' => 0,
            'speech' => 'Patrão, o ' . $SLG . ' hoje está custando R$ ' . $moeda['valores'][$update['result']['parameters']['moeda']]['valor'] . '.'
        );
    } else {
        $bitcoin = json_decode(file_get_contents('https://blockchain.info/pt/ticker'), true);
        $mensagem[] = array(
            'type' => 0,
            'speech' => 'Patrão, esta é a cotação do bitcoin neste instante\n ' . $bitcoin['USD']['symbol'] . ' ' . $bitcoin['USD']['sell'] . ', ' . $bitcoin['EUR']['symbol'] . ' ' . $bitcoin['EUR']['sell'] . ', ' . $bitcoin['BRL']['symbol'] . ' ' . $bitcoin['BRL']['sell'] . '.'
        );
    }

    $mensagem[] = array(
        'type' => 0,
        'speech' => 'Gostaria de realizar uma nova consulta?',
    );

    return array(
        'source' => $update['result']['source'],
        'speech' => $mensagem[0],
        'messages' => $mensagem,
        'displayText' => $mensagem[0],
        'contextOut' => array(
            array(
                'name' => 'ctx-moeda',
                'lifespan' => 1,
                'parameters' => array()
            )
        )
    );
}
