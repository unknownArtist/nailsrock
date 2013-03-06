<?php
	class My_Controller_Plugin_Loader extends Zend_Controller_Plugin_Abstract
{
    /**
     * Constructor
     * 
     * @param  string $env Execution environment
     * @return void
     */
    public function __construct()
    {
   
    }

    /**
     * Route startup hook
     * 
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $request->setModuleName( ucfirst($request->getModuleName()) );
    }

    // ...
}
?>