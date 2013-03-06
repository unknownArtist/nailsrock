<?php 
class MemberController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        if (  My_Auth::getInstance()->isAdmin()  ) {


           // die ("yes");
	} else {
           
$this->_helper->FlashMessenger->setNamespace('warning')->addMessage('Access Denied');
        
           $this->_redirect('/');
}
    }
    
    
     
    
    
    public function indexAction()
    {

}


    
     public function loadaccountstableAction()
    {
         $this->_helper->layout->disableLayout();
      
      $customer_type=$this->_getparam('customer_type');

        
        $tmp1 = new Application_Model_Members();
        //$where = "userID = $userData->userID";
        $accounts = $tmp1->fetchAll()->toArray();
        $this->view->accountsData = $accounts;


        $getConnect = Zend_Db_Table::getDefaultAdapter();
        $getDbTable = new Zend_Db_Select($getConnect);
        
        
        
        
        switch ($customer_type){ 
	case '0':
    $getmembers = $getDbTable->from('members');
	break;

	case '3':
    $getmembers = $getDbTable->from('members');
	break;


	default :
    
        $getmembers = $getDbTable->from('members')->where('vipMember='.$customer_type);
        
}
        
        
        $getResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($getmembers));

        $Paginatedresult = $getResult->setItemCountPerPage(20)
                                     ->setCurrentPageNumber($this->_getParam('page',1));
        $this->view->Members = $Paginatedresult;


             

    }

    
    
    
    public function addaccountAction()
    {
        $this->getResponse()->setHeader('Expires', '', true);
        $this->getResponse()->setHeader('Cache-Control', 'public', true);
        $this->getResponse()->setHeader('Cache-Control', 'max-age=3800');
        $this->getResponse()->setHeader('Pragma', '', true);
    	$form = new Application_Form_Account();
        $this->view->form = $form;
        
        if ( !$this->getRequest()->isPost() ) {
            return;
        }
        if ( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }
        
        $values=$form->getValues();
        $values['password']=base64_encode( $values['password']);
        unset($values['repassword']);
        $members = new Application_Model_Members();
        $values['phCode']="(".$values['phCode'].")";
        if ($members->insert($values)) {
            
              $this->_helper->FlashMessenger->setNamespace('success')->addMessage('New Account Added');
       
            
        }else {
            
            $this->_helper->FlashMessenger->setNamespace('error')->addMessage('Account Can not be created');
        
            
        }

        $this->_redirect('member/accounts');
    
 
}

    public function accountsAction()
    {
        

        $tmp1 = new Application_Model_Members();
        //$where = "userID = $userData->userID";
        $accounts = $tmp1->fetchAll()->toArray();
        $this->view->accountsData = $accounts;


        $getConnect = Zend_Db_Table::getDefaultAdapter();
    

        $getmembers = $getConnect->select()
                                    ->from('members')
                                  ->order('memberID DESC')
                                  ->query()
                                  ->fetchAll();
    
    
                      $paginator = Zend_Paginator::factory($getmembers);   
                  $paginator->setCurrentPageNumber($this->_getParam('page',1));  
                  $paginator->setDefaultItemCountPerPage(10);
                  $this->view->paginator = $paginator;
    
    
        $this->view->Members = $paginator;


    }

    public function viewAccountAction()
    {
    
      $userData = new Zend_Session_Namespace('Default');
      $userData->userID = $this->_request->getParam('memberID');
      $where = "memberID = ".$this->_request->getParam('memberID');

        $tmp1 = new Application_Model_Members();        
        $accounts = $tmp1->fetchAll($where)->toArray();
        $this->view->userdata = $accounts;


        $tmp2 = new Application_Model_Viprewardshistory();
        $vipAccountHistory = $tmp2->fetchAll($where)->toArray();
        $this->view->vipAccountHistory = $vipAccountHistory;

        $tmp3 = new Application_Model_Memberaccountnotes();
        $notes = $tmp3->fetchAll($where)->toArray();
        $this->view->notes = $notes;
        // print_r($vipAccountHistory);
        // die();

            
        $form1 = new Application_Form_Viprewardhistory();
        
        $rewardID=$this->_getParam('rewardID');
        
        if ( $rewardID) {
             $form1->Add->setLabel('Update');
             $form1->populate( $tmp2->select()->where('id='.$rewardID)->query()->fetch(Zend_Db::FETCH_ASSOC)  );
           
        }
        
        
        $this->view->form1 = $form1;

         $reward = new Application_Model_Viprewardshistory();
         $r_data = $reward->fetchAll($where = "memberID = ".$this->_request->getParam('memberID'),'id DESC');
         
         
         
                           $paginator = Zend_Paginator::factory($r_data);   
                  $paginator->setCurrentPageNumber($this->_getParam('page',1));  
                  $paginator->setDefaultItemCountPerPage(10);
         
         $this->view->r_data = $paginator;

        $form2 = new Application_Form_Notes();
        
        $this->view->form2 = $form2;

          $notes = new Application_Model_Memberaccountnotes();
          $n_data = $notes->fetchAll($where = "memberID = ".$this->_request->getParam('memberID'),'id DESC','10,0');
          $this->view->n_data = $n_data; 
         
    }
     public function timeConversion24hTO12h($time_24h)
    {
        // 24-hour time to 12-hour time
        return $time_in_12_hour_format = date("g:i a", strtotime($time_24h));

    }
    
    public function timeConversion12hTO24h($time_12h)
    {
        // 12-hour time to 24-hour time
      return  $time_in_24_hour_format = date("H:i", strtotime($time_12h));

    }
    
    public function editAccountAction()
    {
        $members = new Application_Model_Members();
        $form = new Application_Form_Editaccount();
       
         if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams()))
        {
          
          
               $u_data = array(

                                'vipMember'    =>   $form->getValue('vipMember'),
                                'email'       =>    $form->getValue('email'),
                                'password'    =>    base64_encode($form->getValue('password')),
                                'firstName'   =>    $form->getValue('firstName'),
                                'lastName'    =>    $form->getValue('lastName'),
                                'phone'       =>    $form->getValue('phone'),
                                'address'     =>    $form->getValue('address'),
                                'city'        =>    $form->getValue('city'),
                                'state'       =>    $form->getValue('state'),
                                'zip_code'    =>    $form->getValue('zip_code'),
                                'vipMemberCard'=>$form->getValue('vipMemberCard')
                            ); 
                            
          $where = "memberID  = ".$this->_request->getParam('memberID');
         
                $members->update($u_data,$where);
                $form->reset();

        $this->_redirect('member/accounts');
    
        }else
        {
          $where = "memberID  = ".$this->_request->getParam('memberID');
          $member=$members->fetchRow($where)->toArray();
          
            unset( $member['password'] );     
	 //   echo '<pre>';
//        print_r( $member    );
//        echo '</pre>';
//        
     //   die('DEBUG');
          
          $form->populate($member); 
          $this->view->form = $form;

        }
    }

        public function addRewardpointAction()
        {
           $account = new Application_Model_Members();
                   
           $userData = new Zend_Session_Namespace('Default');
           $form1 = new Application_Form_Vippoints();
           $member_ref=$_POST['member_ref'];
           
          if ( strlen($member_ref)!=4) {
                $this->_helper->FlashMessenger->setNamespace('error')->addMessage('VIP Code Needs to be 4 Digits');
                    return $this->_redirect('/appointments/points');   
                 
            }
           
            $memberID= $account->select()->where('vipMemberCard Like ?',"%$member_ref" )->query()->fetch(Zend_Db::FETCH_OBJ)->memberID;

           
            if ( !$memberID) {
                $this->_helper->FlashMessenger->setNamespace('error')->addMessage('Wrong VIP Code');
                    return $this->_redirect('/appointments/points');   
                 
            }
           
           $this->view->form1 = $form1;    


                  if ($this->getRequest()->isPost() && $this->view->form1->isValid($this->_getAllParams()))
            {
             
                  $vipreward = new Application_Model_Viprewardshistory();

                   $r_data = array(

                                    'memberID'    =>    $memberID,
                                      'note'    =>     $form1->getValue('note'),
                                       'type'    =>     $form1->getValue('type'),
                                    'date'       =>    date("Y/m/d"),
                                    'rewardPoints'      =>    $form1->getValue('rewardPoints'),

                                );   
                                

                  $id=$form1->getValue('id'); 
                  
                  if  ( $id  ){
                                 
                    $vipreward->update($r_data,'id='.$id);
                    
                    
                    
                  } else {
                   
                     
    $vippoint= $account->select()->where('memberId='.$memberID)->query()->fetch(Zend_Db::FETCH_OBJ)->vip_points;

        
        if ( isset( $_POST['Add'] ) ) {
            $data['vip_points']=$r_data['rewardPoints']+$vippoint;
            $r_data['type']='Add';
	} else {
             $data['vip_points']=$vippoint-$r_data['rewardPoints'];
             $r_data['type']='Subtract';
}
        

                   
                $account->update($data,'memberID='.$memberID);   
              
                    $vipreward->insert($r_data);
                    
                  }             
                                
                   
                    
                    
                    
                    return $this->_redirect('appointments/points');   
                    $form1->reset();

           }
          unset($userData->userID);          
        }
        
        
        
        

        public function addRewardhistoryAction()
        {
          
           $userData = new Zend_Session_Namespace('Default');
           $form1 = new Application_Form_Viprewardhistory();
           $this->view->form1 = $form1;    


                  if ($this->getRequest()->isPost() && $this->view->form1->isValid($this->_getAllParams()))
            {
             
                  $vipreward = new Application_Model_Viprewardshistory();

                   $r_data = array(

                                    'memberID'    =>    $userData->userID,
                                      'note'    =>     $form1->getValue('note'),
                                       'type'    =>     $form1->getValue('type'),
                                    'date'       =>    date("Y/m/d"),
                                    'rewardPoints'      =>    $form1->getValue('rewardPoints'),

                                );   
                                
                                
                                
                  $id=$form1->getValue('id'); 
                  
                  if  ( $id  ){
                                 
                    $vipreward->update($r_data,'id='.$id);
                    
                    
                    
                  } else {
                   
                    $account = new Application_Model_Members();
                     
    $vippoint= $account->select()->where('memberId='.$userData->userID)->query()->fetch(Zend_Db::FETCH_OBJ)->vip_points;

        
        if ( isset( $_POST['Add'] ) ) {
            $data['vip_points']=$r_data['rewardPoints']+$vippoint;
            $r_data['type']='Add';
	} else {
             $data['vip_points']=$vippoint-$r_data['rewardPoints'];
             $r_data['type']='subtract';
}
        

                   
                $account->update($data,'memberID='.$userData->userID);   
              
                    $vipreward->insert($r_data);
                    
                  }             
                                
                   
                    
                    
                    
                    return $this->_redirect('/member/view-account/memberID/'.$userData->userID);   
                    $form1->reset();

           }
          unset($userData->userID);          
        }
        
        
        
        
        


    public function addNotesAction()
    {
        $userData = new Zend_Session_Namespace('Default');
        $form2 = new Application_Form_Notes();
        $this->view->form2 = $form2;


                  if ($this->getRequest()->isPost() && $this->view->form2->isValid($this->_getAllParams()))
            {
               
                  $members = new Application_Model_Memberaccountnotes();

                   $u_data = array(

                                    'memberID'   =>   $userData->userID,
                                    'date'       =>    date("Y/m/d"),
                                    'notes'      =>    base64_encode($form2->getValue('Notes')),

                                );
                   
                    $members->insert($u_data);
                    return $this->_redirect('/member/view-account/memberID/'.$userData->userID);  
                    $form2->reset();

           }
        
            unset($userData->userID);

    }



    public function deleteMemberAction()
    {
        $where = "memberID = ".$this->_request->getParam('memberID');

        $account = new Application_Model_Members();
        $account->delete($where);

        $notes = new Application_Model_Memberaccountnotes();
        $notes->delete($where);

        $vipHistory = new Application_Model_Viprewardshistory();
        $vipHistory->delete($where);
        
          $this->_helper->FlashMessenger->setNamespace('success')->addMessage('Member Deleted Successfully');
       
       $this->_redirect('member/accounts');

    }

    public function deleteRewardAction()
    {
        $where = "id = ".$this->_request->getParam('id');


        $vipHistory = new Application_Model_Viprewardshistory();
        $vipHistory->delete($where);
        
          $this->_helper->FlashMessenger->setNamespace('success')->addMessage('VIP Point History Deleted Successfully');
       
       $memID=$this->_getParam('memID');
       if ( $this->_getParam('from') ) {
         $this->_redirect('appointments/points');
       }
       $this->_redirect('member/view-account/memberID/'.$memID);

    }
}

