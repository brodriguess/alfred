import time
import telepot

bot = telepot.Bot('***** PUT YOUR TOKEN HERE *****')

# Experimentar modelo mais aberto (de socket) pegando histórico da conversa
while True:
    msg = bot.getUpdates()
    # Processar mensage
    content_type, chat_type, chat_id = telepot.glance(msg)
        # identificar tipo de mensage (on chat | callback query | inline query | chosen inline result)
    # Responder ao usuário
    if content_type == 'text':
        bot.sendMessage(chat_id, msg['text'])
    time.sleep(10)
