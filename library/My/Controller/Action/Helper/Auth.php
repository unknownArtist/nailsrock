<?php

class My_Controller_Action_Helper_Auth extends Zend_Controller_Action_Helper_Abstract implements IteratorAggregate, Countable
{
   public $auth;
    public function __construct()
    {
        
          $this->auth = Zend_Auth::getInstance();
        
    }

    public function isLoggedIn()
    {
        
        if ($this->auth->hasIdentity()) {
           // Zend_Session::regenerateId();
            return true;
        } else {
            return false;
        }
    }

    public function direct($message)
    {
        return $this->addMessage($message);
    }
}
