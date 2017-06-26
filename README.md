# Alfred

Olá, esse é o repositório do Alfred, o bot que os membros do grupo @BotCaverna do Telegram estão criando, para fins de aprendizado. No grupo, você poderá falar de assuntos relacionados a: ChatBots, PLN, IA, Facebook Messenger, Slack, Telegram, Skype e tudo que esteja relacionado com o mundo dos bots. 

### Como falar com o Alfred?
Para falar com o Alfred você deve colocar a palavra "Alfred" no início do texto. Exemplo:

- Alfred tempo em NomeDaCidade
- Alfred diga o tempo em NomeDaCidade

Desse modo, o Alfred saberá que você estar fazendo uma pergunta para ele, e que ele deve dizer a previsão do "tempo" em determinada cidade. O Alfred vai acessar uma API sobre previsão do tempo e vai lhe responder. O Alfred não interpreta o seu comando, ele apenas ignora tudo que vem antes de "tempo em NomeDaCidade" e executa o comando.

Da mesma forma, o Alfred responde a algumas outras palavras (ou expressões) como se fossem comandos:
 - bom dia
 - boa tarde
 - boa noite
 - bitcoin
 - dólar
 - euro
 - piada
 - nacionalidade
 - idade
 - manda nude
 - repositorio
 - mega sena

Inclusice, você pode mandar uma frase contendo algumas dessas palavras, e o Alfred irá responder todas as palavras que ele identificar.

### Como posso contribuir?
Aqui no Github tem um Editor de Código em formato web, basta você abrir o arquivo habilidades.php e incluir uma nova habilidade para o Alfred. Ou pode fazer o Clone ou Fork deste respositório e mandar um Pull Request (PR). Quando seu PR for aceito, automaticamente o Alfred estará apto a executar a habilidade que você criou.

### Para a próxima versão (1.x) em PHP ...
Teremos as seguinte novidades:
 - Reescrita do Alfred em PHP 5 OO (se não me engano o PHP 7 não foi habilitado no servidor)
 - Interpretação de frases usando alguns algoritmos de Linguagem Natural
 - Banco (txt) de palavras para melhora de compreensão de texto e criação dinâmica de respostas
 - ...

### Para a versão (2x) em PHP ...
Teremos as seguinte novidades:
 - Integração com o API.ai
 - ...
