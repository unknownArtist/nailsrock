<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
        protected function _initAppAutoload()
{
    
    $moduleLoad = new Zend_Application_Module_Autoloader(array(
       'namespace' => '',
       'basePath'   => APPLICATION_PATH
    ));
}
    protected function _initSettings()

    {
        $front = Zend_Controller_Front::getInstance();

        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini',

            'production');




            $base_url = $config->base_url;

$namespace = new Zend_Session_Namespace('Zend_Auth');
$namespace->setExpirationSeconds(24*60*60);


Zend_Session::setOptions(array(
    'cookie_lifetime' => 24*60*60,
    'gc_maxlifetime'  => 24*60*60));

        define('BASE_URL', "http://admin.nailsrock.biz/");
        

// SET AUTHORIZE.NET APIS

Zend_Registry::set( 'api_login_id', '8wxVvQ9d82'  );
Zend_Registry::set( 'transaction_key', '6aLAqSu45M2T8277'  );

Zend_Registry::set( 'md5_setting',  'cricket'  );

//$api_login_id = '2vJ34JSg9';


//$transaction_key = '854L55c7j3JwTVLX';

//$md5_setting = '2vJ34JSg9'; 



    }

   protected function _initTitle()
{
    $view=$this->bootstrap('view')->getResource('view');
    $view->headTitle('Appointment System');
}

}

