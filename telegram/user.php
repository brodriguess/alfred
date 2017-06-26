<?php

namespace BotCaverna\Telegram;

class User
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $username;
    protected $language_code;
    
    public function __construct()
    {
        //
    }
    
    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
    }
    
    public function getFirstName()
    {
        return $this->firstname;
    }
    
    public function setLastName($lastname)
    {
        $this->lastname = $lastname;
    }
    
    public function getLastName()
    {
        return $this->lastname;
    }
    
    public function setUserName($username)
    {
        $this->username = username;
    }
    
    public function getUserName()
    {
        return $username;
    }
    
    public function setLanguageCode($language_code)
    {
        $this->language_code = $language_code;
    }
    
    public function getLanguageCode()
    {
        return $this->language_code;
    }
}
