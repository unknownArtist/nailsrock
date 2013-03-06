<?php

/**
 * @author lolkittens
 * @copyright 2012
 */

class My_Auth
{

    public static $auth = null;
    protected static $_instance = null;


    public static function getInstance()
    {

        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        self::$auth = Zend_Auth::getInstance();


        return self::$_instance;

    }
    public function __construct()
    {


        //   $auth->setStorage(new Zend_Auth_Storage_Session('Users'));

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
    
     public function isVIPMember(  )
    {
        
        //  $members = new Application_Model_Members();

        if ( $this->auth->hasIdentity() ) {
                
        $userName=$this->auth->getIdentity();
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $user=$db->select()->from('members','*')
                                ->where('email=?',$userName)
                                 ->query()
                                 ->fetch(Zend_Db::FETCH_OBJ)
                                 ;
               

     
          if ( $user->vipMember==1 ) {

        return true;

	} 
        }
                  
	  return false;


    }
    public function checkLogin(  $success=true, $failure=true)
    {
        $redircetor= Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        
        $FlashMessenger= Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
       
        
        if ($this->auth->hasIdentity()) {
          
            
      if ( $success ) {
        
            $FlashMessenger->setNamespace('information')->addMessage('already Logged In');
      
        // $redircetor->gotoUrl("admin");
      $redircetor->gotoUrl("/");
       }
       
       return true;
            
        } else {
             
       
      //  $redircetor->gotoUrl("login");
       if ( $failure ) {
        
       }
       return false;
          //  
        }


    }
    public function getLoggedUser($field = null)
    {

        $email = $this->auth->getIdentity();

          $db=Zend_Db_Table_Abstract::getDefaultAdapter();
 

        $user = $db->select('*')
                    ->from(array('m'=>'members'))
                    ->where("m.email=?", $email)->query()->fetch(Zend_Db::FETCH_OBJ);
       
	  //  echo '<pre>'.$email;
//        print_r( $user   );
//        echo '</pre>';
//        
//        die('DEBUG');
        if ($field == null) {
            return $user;
        } else {
            $userArr = (array )$user;
            return $userArr[$field];
        }


    }

    public function isAdmin()
    { 
        //  $members = new Application_Model_Members();



        if ( $this->auth->hasIdentity() ) {
                
             

        $userName=$this->auth->getIdentity();
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        $user=$db->select()->from('adminlogin','*')
                                ->where('adminUsername=?',$userName)
                                 ->query()
                                 ->fetch(Zend_Db::FETCH_OBJ)
                                 ;
                                 
                  
//	    echo '<pre>';
//        print_r(  $user   );
//        echo '</pre>';
//        
//        die('DEBUG');  
//        
//                            
          if ( $user ) {

        return true;

	} 
                  
	  
    }
     return false;
     }
}


?>