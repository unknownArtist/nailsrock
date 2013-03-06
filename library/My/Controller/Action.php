<?php

/**
 * @author lolkittens
 * @copyright 2012
 */
class My_Controller_Action extends Zend_Controller_Action
{

    public function init()
    {

        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past


        date_default_timezone_set('Europe/Berlin');

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        // die ('DEBUG');
        if ($this->getRequest()->getModuleName()=="Admin") {
	 
        $layout=Zend_Layout::getMvcInstance();
        $layout->setLayout('admin/layout');
}
        
        parent::init();
    }


}

?>