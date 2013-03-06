<?php

class Application_Form_Loginvip extends Zend_Form
{

    public function init()
    {
      	$this->setMethod('post');
        $this->setAction('')
             ->setAttrib('id', 'formLogin');

        $loginname = new Zend_Form_Element_Text('userName');
        $loginname->setLabel('Email Address:')
             ->addFilter(new Zend_Filter_StringTrim())
         
        	 ->setRequired(TRUE);

       $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:')
        	          ->addFilter(new Zend_Filter_StringTrim())
             ->setRequired(true);
        	 
        $submitlogin = new Zend_Form_Element_Submit('login');

        $this->addElements(array(

        	$loginname,
        	$password,
        	$submitlogin,

        	));
    }


}