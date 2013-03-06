<?php

class AdminGiftcardController extends Zend_Controller_Action
{

    public function init()
    {


            if (! My_Auth::getInstance()->isAdmin() ) {
                
              $this->_helper->flashMessenger->setNamespace('error')->addMessage("Login As Admin");
        
                    
                 
                $this->_redirect("/");
          
                
            }
            
                $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('loadcard', 'json')
   
        ->initContext();


    }

 public function autocompletecardAction()
    {


            $members = new Application_Model_Members();
            $db=$members->getDefaultAdapter();
            
            $members=array('m'=>"members");
            
          

$term = trim(strip_tags($this->_getParam('term')));

    $result=$db->query("select card_no from gift_cards where card_no LIKE '$term%' ")->fetchAll();
            
                     $rows=$result;
         if (is_array($rows)) {
            
	       foreach ($rows as $row) {
	               $values[]=$row['card_no'];
           }
         }
//     
            echo $this->_helper->json($values);


    }
    
   public   function USAToMySQLDate($usa_date){
    
	list($m,$d,$y)=explode('-',$usa_date);
        
      return  $date="20".$y."-".$m."-".$d;
}
 public  function MySQLToUSADate($mysql_date){
    
	list($y,$m,$d,)=explode('-',$mysql_date);
        
      return  $date=$m.'-'.$d.'-'.substr($y,-2,2);
}
        public function loadcardAction()
    {

        $id = $this->_getParam('id');
        
      
        if ($id)
        {

            $members = new Application_Model_Giftcards();
            $member = $members->select('*')->where('card_no LIKE ?' , "$id")
                                ->query()->fetch();
            $member['date_created']=self::MySQLToUSADate($member['date_created']);
            
            $mem=new Application_Model_Members();
            
            $memberRow=$mem->fetchRow('memberID='.$member['memberID']);
      
            $member['firstName']=$memberRow['firstName'];
            
            echo $this->_helper->json($member);

        }


    }
    
    public function forgetpassSuccessAction()
    {


    }
    
     public function deleteAction()
    {

  $model = new Application_Model_Giftcards();
  
  $id=$this->_getParam('id');
  
  $model->delete('id='.$id);

   $this->_helper->flashMessenger->setNamespace('success')->addMessage("Gift Card Deleted Successfully");
        

                $this->_redirect("admin-giftcard");
    

    }
    public function undotransactionAction()
    {
            $id=$this->_getParam('id');
            
            $model=new Application_Model_Giftcardtransactions();
             
            $giftcardModel=new Application_Model_Giftcards();
            
            $transaction=$model->fetchRow('id='.$id);
            
            $amount=$transaction['amount'];
            $card_id=$transaction['card_id'];
            
                $card=$giftcardModel->fetchRow('id='.$card_id);
           
           
           $giftcardModel->update( array('points'=>$card['points']+$amount),'id='.$card_id );
           
           
           $model->delete('id='.$id);
           
            
            
        $this->_helper->flashMessenger->setNamespace('success')->addMessage("Transaction undone Successfully");
        
                    
                  
        
                $this->_redirect("admin-giftcard/transactions/id/".$card_id);
        

    }
    
    public function deleteTransactionAction(){
        
        
            $id=$this->_getParam('id');
            
            $model=new Application_Model_Giftcardtransactions();
            
            
           $model->delete('id='.$id);
           
            
            
        $this->_helper->flashMessenger->setNamespace('success')->addMessage("Transaction deleted Successfully");
        
                    
                  
        
                $this->_redirect("admin-giftcard/transactions/id/".$id);
        
        
}
    
    
    public function transactionsAction()
    {


            $id=$this->_getParam('id');
            
            $model=new Application_Model_Giftcardtransactions();
            
            
            $modelGift=new Application_Model_Giftcards();
            
            $this->view->giftcard=$modelGift->fetchRow('id='.$id);
            
            $data=$model->fetchAll('card_id='.$id);



                  $paginator = Zend_Paginator::factory($data);   
                  $paginator->setCurrentPageNumber($this->_getParam('page',1));  
                  $paginator->setDefaultItemCountPerPage(3);
                  $this->view->paginator = $paginator;

    }
    
      
    
    public function operationsAction(){
	 $model=new Application_Model_Giftcards();
     
    
    
      switch ( $_POST['type'] ){ 
        
        
	case 'activate':
    
    $model->update(array('active'=>1),'id='.$_POST['card_id']);
    
      $this->_helper->flashMessenger->setNamespace('success')->addMessage("Gift Card Activated Successfully");
      
      
                $this->_redirect("admin-giftcard");
              
 
	break;

	case 'subtract':
    
  //   $subtract_amount= trim($_POST['subtract_amount']);
     
     $gift_card=$model->fetchRow("id=".$_POST['card_id']);
     
        $card_no=$gift_card->card_no;

                  
                  $user_points=trim($_POST['subtract_amount']);
                  
                  
            
                   $result= $model->select()
                                ->where("card_no=?",$card_no)
                                ->where("points>=?",  $user_points )
                                ->where("active=1")
                             
                             
                             
                             
                                ->query()
                                ->fetch(Zend_Db::FETCH_OBJ);
                  
                  if ( $result ) {
                    
                  
                  // imcrease VIP Point of the user
                    
                    
                 
                  
                  

                              $account = new Application_Model_Members();
                 
    $gift_point= $result->points;


        $data['points']=$gift_point-$user_points;
        
        
        
        
        
        
               if ( !$gift_point ) {
                
             //   $data['active']=;
                
               }
                $model->update($data,'id='.$result->id);   
                
                
                $modelTransactions=new Application_Model_Giftcardtransactions();
                
                $transactionData['date']= $now = date('Y-m-d H:i:s', time());
                $transactionData['card_id']=$result->id;
                $transactionData['amount']=$user_points;
               $transactionData['note']=$_POST['note'];
                
                
                $modelTransactions->insert( $transactionData );
                
      
                     
                     
                    
                     // making card active so that it is used once
                     
                    
        $this->_helper->flashMessenger->setNamespace('success')->addMessage("Gift Card Approved and Balance Subtracted");
      
                $this->_redirect("admin-giftcard/transactions/id/".$result->id);
              
                  } else {
                    
                    

        $this->_helper->flashMessenger->setNamespace('error')->addMessage("Request can not be processed");
        
                $this->_redirect("admin-giftcard");
              
                    
                  }


    
    
	break;


}
    
    }
    
    
    
    public function approveGiftcardAction(){
	
      $form = new Application_Form_Giftcardapprove();
        $this->view->form= $form;
        
        
        
        if ($this->getRequest()->isPost()) {

            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {
                
                $values=$form->getValues();
                
                
                $card_no=$values['card_no'];
                  // checking if card is valid
                  
                  
                  $model=new Application_Model_Giftcards();
                  
                  $user_points= $values['user_points'];
                  
                  
            
                   $result= $model->select()
                                ->where("card_no=?",$card_no)
                                ->where("points>=?",  $user_points )
                                ->where("active=0")
                             
                             
                             
                             
                                ->query()
                                ->fetch(Zend_Db::FETCH_OBJ);
                  
                  if ( $result ) {
                    
                  
                  // imcrease VIP Point of the user
                    
                    
                 
                  
                  

                              $account = new Application_Model_Members();
                 
    $gift_point= $result->points;


        $data['points']=$gift_point-$user_points;
               
               
               if ( !$gift_point ) {
                
                $data['active']=1;
                
               }
                $model->update($data,'id='.$result->id);   
                
                
                $modelTransactions=new Application_Model_Giftcardtransactions();
                
                $transactionData['date']= $now = date('Y-m-d H:i:s', time());
                $transactionData['card_id']=$result->id;
                $transactionData['amount']=$user_points;
                $transactionData['note']=$values['note'];
                
                
                $modelTransactions->insert( $transactionData );
                
      
                     
                     
                    
                     // making card active so that it is used once
                     
                    
        $this->_helper->flashMessenger->setNamespace('success')->addMessage("Gift Card Approved");
      
                $this->_redirect("admin-giftcard/transactions/id/".$result->id);
              
                  } else {
                    
                    

        $this->_helper->flashMessenger->setNamespace('error')->addMessage("active Gift Card");
        
                $this->_redirect("admin-giftcard");
              
                    
                  }
          
                

                $form->populate($formData);
 
 
            } else {
                $form->populate($formData);
            }
 
        }
}

    
    public function addGiftcardAction(){
	
    $form = new Application_Form_Loginvip();
        $this->view->AdminSignIn = $form;


        $authAdapter = $this->getAuthAdapter();



        if ($this->getRequest()->isPost()) {

            $formData = $this->getRequest()->getPost();


            if ($form->isValid($formData)) {
                $admin = $form->getValue('userName');
                $password = base64_encode($form->getValue('password'));

                $authAdapter->setIdentity($admin)->setCredential($password);
                //   $authAdapter->setExpirationSeconds( 24*60*60  );
                $auth = Zend_Auth::getInstance();


                $result = $auth->authenticate($authAdapter);
                   

                if ($result->isValid()) {

                    $s = new Zend_Session_Namespace($auth->getStorage()->getNamespace());
  
                    $s->setExpirationSeconds(24 * 60 * 60);

                    $this->_redirect('home');
                } else {
                    $form->populate($formData);
                    $this->view->SignUpError = "active Username or Password";
                    
                    

                }

            } else {
                $form->populate($formData);
            }
        }
}
    
    public function indexAction()
    {
 
 
        $model=new Application_Model_Giftcards();
        
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
        
        $result=$db->select()->from( array('gc'=>'gift_cards') )
                             ->join( array('u'=>'members'), 'gc.memberID=u.memberID',array('u.firstName') );
        
        $result=$result->query()->fetchAll(Zend_Db::FETCH_OBJ);
        
        
     //          
//	    echo '<pre>';
//        print_r(   $result  ); fdhr e twe 
//        echo '</pre>';  
//        '\\'
//        die('DEBUG');
                  $paginator = Zend_Paginator::factory(  $result );   
                  $paginator->setCurrentPageNumber($this->_getParam('page',1));  
                  $paginator->setDefaultItemCountPerPage(10);
                  $this->view->paginator = $paginator;
                
 
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
