<?php

namespace BotCaverna\Telegram\Message;

class Message
{
    //TODO: implemente https://core.telegram.org/bots/api#message
    
    protected $message_id; // int
    protected $from; // User
    protected $date; // int
    protected $chat; // Chat
    
    protected $text; // String
    
    // Documents, Photos e Videos
    protected $document; // Document
    protected $photo; // PhotoSize
    protected $caption; // String
    
    public function setMessageID()
    {
        
    }
    
    public function getMessageID()
    {
        
    }
    
    public function setFrom()
    {
        
    }
    
    public function getFrom()
    {
        
    }
    
    public function setDate()
    {
        
    }
    
    public function getDate()
    {
        
    }
    
    public function setChat(Chat $chat)
    {
        $this->chat = $chat;
    }
    
    public function getChat()
    {
        return $this->chat;
    }
    
    public function setText($text)
    {
        $this->text = $text;
    }
    
    public function getText()
    {
        return $this->text;
    }
    
    public function setDocument(Document $document)
    {
        $this->document = $document;
    }
    public function getDocument()
    {
        return $this->document;
    }
    
}
