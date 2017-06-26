<?php

namespace BotCaverna\Telegram;

class Bot
{
    private $version = '1.0.0';
    
    private $api_key = '';
    
    protected $api_url = 'https://api.telegram.org/bot';
    
    protected $bot_name = '';
    
    protected $update;

    public function __construct($key)
    {
        $this->setApiKey($key);
    }
    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function setApiKey($key)
    {
        $this->api_key = $key;
    }
    
    public function getApiKey()
    {
        return $this->api_key;
    }
    
    public function getApiURL()
    {
        return $this->api_url.$this->getApiKey().'/';
    }
    
    public function setBotName($bot_name)
    {
        $this->bot_name = $bot_name;
    }
    
    public function getBotName()
    {
        return $this->bot_name;
    }
    
    public function update()
    {
        $content = file_get_contents("php://input");
        $this->update = json_decode($content, true);

        if (! $this->update) {
          // receive wrong update, must not happen
          exit;
        }
    }

}
