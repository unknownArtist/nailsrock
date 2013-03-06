<?php 
class UserController extends Zend_Controller_Action
{

    public function init()
    {
    }
    
    
     
    
    
    public function indexAction()
    {

}
    
    public function signupsuccessAction()
    {

}


    public function signupAction()
    {
        $this->getResponse()->setHeader('Expires', '', true);
        $this->getResponse()->setHeader('Cache-Control', 'public', true);
        $this->getResponse()->setHeader('Cache-Control', 'max-age=13800');
        $this->getResponse()->setHeader('Pragma', '', true);
    	$form = new Application_Form_Account();
        
     //   $form->removeElement('password');
       //    $form->removeElement('repassword');
              $form->removeElement('vipMember');
               $form->removeElement('vipMemberCard');
               $form->submit->setLabel('Signup');
          //     $form->setAction('user/signup');
              
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

        $this->_redirect('user/signupsuccess');
    
 
}

    public function accountsAction()
    {
        
        
$this->getResponse()->setHttpResponseCode(500);


        $tmp1 = new Application_Model_Members();
        //$where = "userID = $userData->userID";
        $accounts = $tmp1->fetchAll()->toArray();
        $this->view->accountsData = $accounts;


        $getConnect = Zend_Db_Table::getDefaultAdapter();
        $getDbTable = new Zend_Db_Select($getConnect);

        $getmembers = $getDbTable->from('members');
        $getResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($getmembers));

        $Paginatedresult = $getResult->setItemCountPerPage(20)
                                     ->setCurrentPageNumber($this->_getParam('page',1));
        $this->view->Members = $Paginatedresult;


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

            
        $form1 = new Application_Form_viprewardhistory();
        
        $rewardID=$this->_getParam('rewardID');
        
        if ( $rewardID) {
             $form1->Add->setLabel('Update');
             $form1->populate( $tmp2->select()->where('id='.$rewardID)->query()->fetch(Zend_Db::FETCH_ASSOC)  );
           
        }
        
        
        $this->view->form1 = $form1;

         $reward = new Application_Model_Viprewardshistory();
         $r_data = $reward->fetchAll($where = "memberID = ".$this->_request->getParam('memberID'),'id DESC','10,0');
         $this->view->r_data = $r_data; 

        $form2 = new Application_Form_Notes();
        
        $this->view->form2 = $form2;

          $notes = new Application_Model_Memberaccountnotes();
          $n_data = $notes->fetchAll($where = "memberID = ".$this->_request->getParam('memberID'),'id DESC','10,0');
          $this->view->n_data = $n_data; 
         
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
                                'zip_code'    =>    $form->getValue('zip_code')
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


        public function addRewardhistoryAction()
        {
          
           $userData = new Zend_Session_Namespace('Default');
           $form1 = new Application_Form_viprewardhistory();
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
    
                   switch ($form1->getValue('type')){ 
	case 'Add':
    
  
    $data['vip_points']=$r_data['rewardPoints']+$vippoint;
	break;

	case 'subtract':
    
    $data['vip_points']=$vippoint-$r_data['rewardPoints'];

	break;


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
        
          $this->_helper->FlashMessenger->setNamespace('success')->addMessage('Memeber Deleted Successfully');
       
       $this->_redirect('member/accounts');

    }

    public function deleteRewardAction()
    {
        $where = "id = ".$this->_request->getParam('id');


        $vipHistory = new Application_Model_Viprewardshistory();
        $vipHistory->delete($where);
        
          $this->_helper->FlashMessenger->setNamespace('success')->addMessage('VIP Point History Deleted Successfully');
       
       $memID=$this->_getParam('memID');
       $this->_redirect('member/view-account/memberID/'.$memID);

    }
}

