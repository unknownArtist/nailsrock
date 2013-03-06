<?php
//$url = 'http://admin.nailsrock.biz/';
//$data =$_POST;
//
//// use key 'http' even if you send the request to https://...
//$options = array('http' => array('method'  => 'GET','content' => 'giftcard/confirm-giftcard/?'.http_build_query($data)));
//$context  = stream_context_create($options);
//$result = file_get_contents($url, false, $context);
//
//var_dump($result);

$url = 'http://admin.nailsrock.biz/giftcard/add-giftcard';
$data =array('controller'=>'giftcard','action'=>'getuserid');

 
$options = array('http' => array('method'  => 'GET','content' => http_build_query($data)));
$context  = stream_context_create($options);
$result = file_get_contents($url,false,$context);

var_dump($result);



die ("f");

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../application/models'),
    get_include_path(),
)));
  

             date_default_timezone_set('EST');


/** Zend_Application */

require_once 'Zend/Application.php';

require_once 'Zend/Config/Ini.php';

require_once 'Zend/Db.php';

require_once 'Zend/Db/Table.php';

require_once 'functions.php';

require_once 'My/Form/Helper.php';

require_once 'Giftcards.php';


require_once 'Members.php';

require_once 'Viprewardshistory.php';




$configs = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini',

    'staging', $options);

$dbconfig = $configs->resources->db;



$db = Zend_Db::factory($dbconfig);



Zend_Db_Table::setDefaultAdapter($db);


//$api_login_id = Zend_Registry::get( 'api_login_id' );
//$transaction_key=Zend_Registry::get( 'transaction_key'  );
//
//$md5_setting =Zend_Registry::get( 'md5_setting' );

$api_login_id = '8wxVvQ9d82'  ;
$transaction_key= '6aLAqSu45M2T8277'  ;

$md5_setting = 'cricket'  ;


$amount=$_POST['x_amount'];

$responseVerifyInput=$md5_setting.$api_login_id.$_POST['x_trans_id'].$amount;
 
  //  echo md5($responseVerifyInput)." ".$_POST['x_MD5_Hash'];
    
    
 //   echo "<br/>".$api_login_id." ".$transaction_key." ".$md5_setting;
    
 //die ("D");
 
  $memberID=$_POST['x_cust_id'];
 
 
if (  md5($responseVerifyInput)== strtolower($_POST['x_MD5_Hash'])  ) {
    
      $model = new Application_Model_Giftcards();
              
                $values1['points']=$amount;
                $values1['note']=$_POST['x_description'];
                $values1['date_created'] = date("Y-m-d", time());

                $values1['memberID'] = $_POST['x_cust_id'];

                $values1['card_no'] = rand(1111,9999)."-".rand(1111,9999)."-".rand(1111,9999)."-".rand(1111,9999);

//
//                   echo '<pre>';  
//                        print_r(  $values   );
//                        echo '</pre>';
//                        //                        die('DEBUG');
                
                $model->insert($values1);

                $account = new Application_Model_Members();

                $vippoint = $account->select()->where('memberId=' . $memberID)->query()->fetch(Zend_Db::
                    FETCH_OBJ)->vip_points;






                $data['vip_points'] = $vippoint + $amount;
                

                
           //      adding VIP Reward History
                
                        $vipreward = new Application_Model_Viprewardshistory();

                   $r_data = array(

                                    'memberID'    =>    $memberID,
                                      'note'    =>    $_POST['x_description'],
                                       'type'    =>    "Add ( Gift Card )",
                                    'date'       =>    date("Y/m/d"),
                                    'rewardPoints'      =>   $amount,

                                );   
                          
                          $vipreward->insert(  $r_data );      

                $account->update($data, 'memberID=' . $memberID);
       
        
    
} else {
    
  
  
}
      
      
      
      
       
	    echo '<pre>';
     //   print_r(  $db   );
        echo '</pre>';
        
        die('DEBUG');

