<?php

// Define path to application directory

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__file__) .

    '/application'));



// Define application environment

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?

    getenv('APPLICATION_ENV') : 'production'));



// Ensure library/ is on include_path

set_include_path(implode(PATH_SEPARATOR, array(

    realpath('library'),

    get_include_path(),

    )));



/** Zend_Application */

require_once 'Zend/Application.php';

require_once 'Zend/Config/Ini.php';

require_once 'Zend/Db.php';

require_once 'Zend/Db/Table.php';

require_once 'functions.php';

require_once 'My/Form/Helper.php';

nocache();





$configs = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini',

    'staging', $options);

$dbconfig = $configs->resources->db;



$db = Zend_Db::factory($dbconfig);



Zend_Db_Table::setDefaultAdapter($db);


       
	    echo '<pre>';
        print_r(  $db   );
        echo '</pre>';
        
        die('DEBUG');

