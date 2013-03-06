<?php

class VipmemberController extends Zend_Controller_Action
{

    public function init()
    {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $email = $this->_getParam('email', '');
        $password = $db->select()->from('members')->where('email=?', $email)->query()->
            fetch(Zend_Db::FETCH_OBJ)->password;
             
            
          if ( My_Auth::getInstance()->isAdmin() ){
            
            
            
            $this->_helper->FlashMessenger->setNamespace('warning')->addMessage('You are Logged as Admin, Logout before Login as VIP Member');

                    $this->_redirect('/');
          }  
            
            

    }
    
public function vipPointsAction(){
    $memberID=My_Auth::getInstance()->getLoggedUser('memberID');
	
      $where = "memberID = ".$memberID;

       $tmp2 = new Application_Model_Viprewardshistory();
        $vipAccountHistory = $tmp2->fetchAll($where)->toArray();
        $this->view->r_data = $vipAccountHistory;
    
}


    public function forgetpassAction()
    {

        $email = trim($this->_getParam('email', ''));
        
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $password64 = $db->select()->from('members')->where('email=?', $email)->query()->
                fetch(Zend_Db::FETCH_OBJ)->password;
            $password = base64_decode($password64);

        if ($password)
        {

            $mail = new Zend_Mail();
           // $mail->setBodyText('My Nice Test Text');
            $mail->setBodyHtml('Here is your Password:'.$password);
            //$mail->setFrom('somebody@example.com', 'Some Sender');
            $mail->addTo($email);
            $mail->setSubject('Forget Password');
            
            
          //  if ( strstr($_SERVER['HTTP_HOST'],'localhost') ) {
                
               $mail->send();
               
               $this->_redirect('/vipmember/forgetpass-success');

          //  } else {
                // $this->_redirect('/vipmember/forgetpass-success');
                

                

          //  die('DEBUG');

        }
    }

    public function forgetpassSuccessAction()
    {


    }
    public function indexAction()
    { 
        $form = new Application_Form_Loginvip();
        $this->view->AdminSignIn = $form;


        $authAdapter = $this->getAuthAdapter();

        if ($this->getRequest()->isPost())
        {

            $formData = $this->getRequest()->getPost();


            if ($form->isValid($formData))
            {
            
                $admin = $form->getValue('userName');
                $password = base64_encode($form->getValue('password'));
                 
                $authAdapter->setIdentity($admin)->setCredential($password);
             //   $authAdapter->setExpirationSeconds( 24*60*60  );

                $auth = Zend_Auth::getInstance();
                
                
                
                

                $result = $auth->authenticate($authAdapter);


                if ($result->isValid())
                {
                
$s = new Zend_Session_Namespace(
    $auth->getStorage()->getNamespace() );

$s->setExpirationSeconds( 24*60*60 );

                    $this->_redirect('home');
                } else
                {
                    $form->populate($formData);
                    $this->view->SignUpError = "Invalid Username or Password";
                }

            } else
            {
                $form->populate($formData);
            }
        }
    }

    private function getAuthAdapter()
    {
        $auth = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $auth->setTableName('members')->setIdentityColumn('email')->setCredentialColumn('password');

        return $auth;
    }

    public function createAction()
    {


    }

    public function logoutAction()
    {


        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index');
    }

}
