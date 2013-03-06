<?php

/**
 * @author lolkittens
 * @copyright 2012
 */
class My_Controller_Actionadmin extends Zend_Controller_Action
{


 public function init()
    {
         parent::init();
        
$front=Zend_Controller_Front::getInstance();
               

        $this->view->modules=self::getAllModules();

       
	   
       $this->view->all_actions= self::getAllModConActions();
    

        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past


        date_default_timezone_set('Europe/Berlin');

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        // die ('DEBUG');
               

            $layout=Zend_Layout::getMvcInstance();
        
        $layout->setLayout('admin/layout');
       
    
  
    if (!(My_Auth::getInstance()->isLoggedIn() && My_Auth::getInstance()->isAdmin() )  ){
        
      $this->_helper->FlashMessenger->setNamespace('warning')->addMessage('Restricted Access');
      $this->_redirect('/');
    }
  
        
       
       
    }

 public function getAllModConActions() {
        $module_dir = $this->getFrontController()->getControllerDirectory();
        $resources = array();
       

        foreach($module_dir as $dir=>$dirpath) {
            $diritem = new DirectoryIterator($dirpath);
            foreach($diritem as $item) {
                if($item->isFile()) {
                    if(strstr($item->getFilename(),'Controller.php')!=FALSE) {
                        include_once $dirpath.'/'.$item->getFilename();
                    }
                }
            }
            
            
         

            foreach(get_declared_classes() as $class){
                if(is_subclass_of($class, 'Zend_Controller_Action')) {
                    $functions = array();

                    foreach(get_class_methods($class) as $method) {
                        if(strstr($method, 'Action')!=false) {
                            array_push($functions,substr($method,0,strpos($method,"Action")));
                        }
                    }
                    $c = strtolower(substr($class,0,strpos($class,"Controller")));
                    $resources[$dir][$c] = $functions;
                }
            }
            
      
        }
   //              	    echo '<pre>';
//        print_r(  $resources   );
//        echo '</pre>';
//        
//        die('DEBUG');
        return $resources;
        
    }

public function getAllModules(){
    
    $path = APPLICATION_PATH."/modules";
$results = scandir($path);

foreach ($results as $result) {
    if ($result === '.' or $result === '..') continue;

    if (is_dir($path . '/' . $result)) {
        //code to use if directory
        $modules[]=$result;
    }
}


return $modules;
	
}
public function getAllModuleControllersActions(){
    
     $front = $this->getFrontController();
	$acl = array();

	foreach ($front->getControllerDirectory() as $module => $path) {

		foreach (scandir($path) as $file) {

			if (strstr($file, "Controller.php") !== false) {

				include_once $path . DIRECTORY_SEPARATOR . $file;

				foreach (get_declared_classes() as $class) {

					if (is_subclass_of($class, 'Zend_Controller_Action')) {

						$controller = strtolower(substr($class, 0, strpos($class, "Controller")));
						$actions = array();

						foreach (get_class_methods($class) as $action) {

							if (strstr($action, "Action") !== false) {
								$actions[] = $action;
							}
						}
					}
				}

				$acl[$module][$controller] = $actions;
			}
		}
	}
    return $acl;

}

   
}

?>