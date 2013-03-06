<?php

class GiftcardController extends Zend_Controller_Action
{

    public function init()
    {

  require_once 'Authorizenet/AuthorizeNet.php';

    }



    public function forgetpassSuccessAction()
    {


    }
    public function genRandomString()
    {
        $length = 15;
        $characters = "0123456789abcdefghijklmnopqrstuvwxyz";

        for ($p = 0; $p < $length; $p++) {
            if ($p == "0") {
                $string = $characters[mt_rand(0, strlen($characters))];
            } else {
                $string .= $characters[mt_rand(0, strlen($characters))];
            }
        }
        return $string;
    }


      public function downloadAction()
    {
        
                 if (! My_Auth::getInstance()->isLoggedIn() ) {
                
              $this->_helper->flashMessenger->setNamespace('error')->addMessage("Login As VIP Member");
        
                    
                 
                $this->_redirect("vipmember");
          
                
            }

        header("Content-Type: application/x-pdf");
        header("Content-Disposition: attachment; filename=giftcard.pdf");
        header("Cache-Control: no-cache, must-revalidate");


        $id = $this->_getParam('id');
        $model = new Application_Model_Giftcards();

        //$giftcard=$model->fetchRow('id='.$id);

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $giftcard = $db->select()->from(array('gc' => 'gift_cards'))->join(array('u' =>
                'members'), 'gc.memberID=u.memberID', array('u.firstName', 'u.lastName'))->
            where('gc.id=?', $id)->query()->fetch(Zend_db::FETCH_OBJ);


        try {
            // create PDF
            $pdf = new Zend_Pdf();

            // create A4 page
            $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);

            // define font resource
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);


        
            $image = Zend_Pdf_Image::imageWithPath('nailsrock-logo.png'); 
        $page->drawImage($image, 100, 720, 210, 820);

            // set font for page
            // write text to page
            
            $page->setFillColor(new Zend_Pdf_Color_Rgb(1,0,0))->setFont($font, 25);   
            
            $page->drawText("GIFT CARD", 250, 780 );
                     
            $page->setFont($font, 15)->drawText('Card No: ' . $giftcard->card_no, 250, 740)->
                drawText('Card Balance: $' . $giftcard->points, 250, 720)->drawText('Created By: ' .
                $giftcard->firstName . " " . $giftcard->lastName, 250, 700)->drawText('Date Created: ' .
                $this->MySQLToUSADate($giftcard->date_created), 250, 680);
                
                
            $page->drawText( "Phone: 954.360.6888",200, 650 );    
            
            $page->drawText( "5913 Lyons Road Coconut Creek, FL.33073",100, 630 );    

            
            // add page to document
            $pdf->pages[] = $page;

            echo $pdf->render();


        }
        catch (Zend_Pdf_Exception $e) {
            die('PDF error: ' . $e->getMessage());
        }
        catch (exception $e) {
            die('Application error: ' . $e->getMessage());
        }

        exit(1);


    }
    
    // this action will hanldle the gifcard bought of external users who are not logged In
    // They user details will be inserted to db and new ono VIP user will be created before t
    // Their buying is inserted in the db upon confirmation of payment from authorize.net
    
    
    
    
    
    public function buyExternalGiftcardAction(){
	
    $form=new Application_Form_Giftcardexternal();
    
    $this->view->form=$form;
    
        if ($this->getRequest()->isPost()) {

            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) {



}
}
    
    
}
    public function paymentAction()
    {
        
//               
//	    echo '<pre>';
//        print_r(  is_integer( (integer)  trim( $_POST['x_amount'])  )     );
//        echo '</pre>';
//        
//        die('DEBUG');
//        
        if ( !  is_integer( (integer)  trim( $_POST['x_amount'])  )  ){
               $this->_helper->flashMessenger->setNamespace('error')->addMessage("Invalid Amount");
        
                    
                 
                $this->_redirect("giftcard/add-giftcard");
          
        }
        
        }
    
    public function USAToMySQLDate($usa_date)
    {

        list($m, $d, $y) = explode('-', $usa_date);

        return $date = "20" . $y . "-" . $m . "-" . $d;
    }
    public function MySQLToUSADate($mysql_date)
    {

        list($y, $m, $d, ) = explode('-', $mysql_date);

        return $date = $m . '-' . $d . '-' . substr($y, -2, 2);
    }
    public function invalidAction()
    {

    }
    
        public function getuseridAction()
    {


                echo $memberID = My_Auth::getInstance()->getLoggedUser('memberID');
                die('');

    }
    

    public function addGiftcardAction()
    {

          	$form = new Application_Form_Giftcard();
        $this->view->form = $form;
        
        if ( !$this->getRequest()->isPost() ) {
            return;
        }
        if ( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }
        
        
        
        $this->renderScript('giftcard/payment.phtml');
        
        

}

    public function buygiftcardsuccessAction()
    {

       

}





public function confirmGiftcardAction(){
    
//            $this->_helper->layout->disableLayout();
//             $this->_helper->viewRenderer->setNoRender();
//	    echo '<pre>';
//        print_r( $this->getRequest()->getParams()    );
//        echo '</pre>';
//        
//        die('DEBUG');
           
	   
	  require_once 'Authorizenet/AuthorizeNet.php';

    /**
     
     array (
  'controller' => 'giftcard',
  'action' => 'confirm-giftcard',
  'module' => 'default',
  'x_response_code' => '1',
  'x_response_reason_code' => '1',
  'x_response_reason_text' => 'This transaction has been approved.',
  'x_avs_code' => 'Y',
  'x_auth_code' => 'R5W2AQ',
  'x_trans_id' => '2180794233',
  'x_method' => 'CC',
  'x_card_type' => 'Discover',
  'x_account_number' => 'XXXX0012',
  'x_first_name' => '',
  'x_last_name' => '',
  'x_company' => '',
  'x_address' => '',
  'x_city' => '',
  'x_state' => '',
  'x_zip' => '',
  'x_country' => '',
  'x_phone' => '',
  'x_fax' => '',
  'x_email' => '',
  'x_invoice_num' => '',
  'x_description' => 'sgsgasg',
  'x_type' => 'auth_capture',
  'x_cust_id' => '',
  'x_ship_to_first_name' => '',
  'x_ship_to_last_name' => '',
  'x_ship_to_company' => '',
  'x_ship_to_address' => '',
  'x_ship_to_city' => '',
  'x_ship_to_state' => '',
  'x_ship_to_zip' => '',
  'x_ship_to_country' => '',
  'x_amount' => '20.00',
  'x_tax' => '0.00',
  'x_duty' => '0.00',
  'x_freight' => '0.00',
  'x_tax_exempt' => 'FALSE',
  'x_po_num' => '',
  'x_MD5_Hash' => 'B9E8FF2BC40121D4CBA962259B6A9852',
  'x_cvv2_resp_code' => '',
  'x_cavv_response' => '2',
  'x_test_request' => 'false',
)  
     
     */


$api_login_id = Zend_Registry::get( 'api_login_id' );
$transaction_key=Zend_Registry::get( 'transaction_key'  );

$md5_setting =Zend_Registry::get( 'md5_setting' );



$amount=$_POST['x_amount'];

$responseVerifyInput=$md5_setting.$api_login_id.$_POST['x_trans_id'].$amount;
 
  //  echo md5($responseVerifyInput)." ".$_POST['x_MD5_Hash'];
    
    
 //   echo "<br/>".$api_login_id." ".$transaction_key." ".$md5_setting;
    
 //die ("D");
 
 
 
 
if (  md5($responseVerifyInput)== strtolower($_POST['x_MD5_Hash'])  ) {
    
      $model = new Application_Model_Giftcards();
              
                $values1['points']=$amount;
                $values1['note']=$_POST['x_description'];
                $values1['date_created'] = date("Y-m-d", time());


                $memberID =  $_POST['x_cust_id'];


                $values1['memberID'] = $memberID;

                $values1['card_no'] = rand(1111,9999)."-".rand(1111,9999)."-".rand(1111,9999)."-".rand(1111,9999);

//
//                   echo '<pre>';  
//                        print_r(  $values   );
//                        echo '</pre>';
//                        //                        die('DEBUG');
                
              $id=  $model->insert($values1);
              
                         $db = Zend_Db_Table_Abstract::getDefaultAdapter();

            $giftcard = $db->select()->from(array('gc' => 'gift_cards'))->join(array('u' =>
                    'members'), 'gc.memberID=u.memberID', array('u.firstName', 'u.lastName'))->
                where('gc.id=?', $id)->query()->fetch(Zend_db::FETCH_OBJ);


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
       
            //  $this->_helper->flashMessenger->setNamespace('success')->addMessage("Gift Card Purchased Successfully");
        

              //  $this->_redirect("giftcard");
              
              
              // generate pdf and send to client
              
              
              
            try {
                // create PDF
                $pdf = new Zend_Pdf();

                // create A4 page
                $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);

                // define font resource
                $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);


                $image = Zend_Pdf_Image::imageWithPath('nailsrock-logo.png');
                $page->drawImage($image, 100, 720, 210, 820);

                // set font for page
                // write text to page

                $page->setFillColor(new Zend_Pdf_Color_Rgb(1, 0, 0))->setFont($font, 25);

                $page->drawText("GIFT CARD", 250, 780);

                $page->setFont($font, 15)->drawText('Card No: ' . $giftcard->card_no, 250, 740)->
                    drawText('Card Balance: $' . $giftcard->points, 250, 720)->drawText('Created By: ' .
                    $giftcard->firstName . " " . $giftcard->lastName, 250, 700)->drawText('Date Created: ' .
                    $this->MySQLToUSADate($giftcard->date_created), 250, 680);


                $page->drawText("Phone: 954.360.6888", 200, 650);

                $page->drawText("5913 Lyons Road Coconut Creek, FL.33073", 100, 630);

                // add page to document
                $pdf->pages[] = $page;

                $attachment = $pdf->render();

                $to = $_POST['x_email'];
                $to_name = $_POST['x_first_name'] . " " . $_POST['x_last_name'];

                // $to="milton.2002@yahoo.com";
                //   $to_name="milton";

                $mail = new Zend_Mail();

                $html_body = "<h1>" . "Thank You for Buying Gift Card." . "</h1>" .
                    "<p>Your Gift is attached with this email.</p>";

                //$mail->setType(Zend_Mime::MULTIPART_RELATED);

                $mail->setBodyHtml($html_body);

                $mail->setFrom('noreply@nailsrock.biz', 'Nailsrock Admin');
                $mail->addTo($to, $to_name);
                $mail->setSubject('Gift Card from Nailsrock');


                $att = $mail->createAttachment($attachment);
                //$att->disposition = 'Zend_Mime::DISPOSITION_INLINE';
                //$att->encoding = 'Zend_Mime::ENCODING_BASE64';
                $att->filename = 'giftcard.pdf';
                $att->type = 'application/pdf';
                //$mail->addAttachment($att);
                $mail->send();

            //    $this->renderScript("giftcard/successext.phtml");


                //    exit(1);


            }
            catch (Zend_Pdf_Exception $e) {
                die('PDF error: ' . $e->getMessage());
            }
            catch (exception $e) {
                die('Application error: ' . $e->getMessage());
            }
              
               $this->renderScript("giftcard/success.phtml");
    
} else {
    
    $this->renderScript("giftcard/failure.phtml");
  
           ;
    
  
}
 
}
   // public function addGiftcardAction()
//    {
//
//
//        $form = new My_Form_Authorizenetpaymentform();
//        $model = new Application_Model_Giftcards();
//
//        
//
//       $user= My_Auth::getInstance()->getLoggedUser();
//       
//
//        $form->first_name->setValue( $user->firstName  );
//        
//         $form->last_name->setValue( $user->lastName  );
//         $form->email->setValue( $user->email );
//          $form->address->setValue( $user->address );
//        
//        
//        
//        $this->view->form = $form;   
//            
//        if (!$this->getRequest()->isPost()) {
//            return;
//        }
//
//
//        if (!$form->isValid($this->getRequest()->getPost())) {
//
//            return;
//        }
//            
//   
//
//        require_once 'Authorizenet/AuthorizeNet.php';
//
//
//$values=$form->getValues();
//
//$transaction = new AuthorizeNetAIM('2vJ34JSg9', '854L55c7j3JwTVLX');
//$transaction->amount = $values['amount'];
//$transaction->card_num = $values['card_num'];
//$transaction->exp_date = $values['exp_date'];
//$transaction->card_code=$values['card_code'];
//
//
//$transaction->first_name=$values['first_name'];
//$transaction->last_name=$values['last_name'];
//$transaction->email=$values['email'];
//$transaction->address=$values['address'];
//
//
//
//  
//
//$response = $transaction->authorizeAndCapture();
//
//if ($response->approved) {
//    
//    
//                    $values = $form->getValues();
//
//                $values1['points']=$values['amount'];
//                $values1['note']=$values['note'];
//                $values1['date_created'] = date("Y-m-d", time());
//
//
//                $memberID = My_Auth::getInstance()->getLoggedUser('memberID');
//
//
//                $values1['memberID'] = $memberID;
//
//                $values1['card_no'] = $this->genRandomString();
//
//
//                //   echo '<pre>';  
//                //        print_r(  $values   );
//                //        echo '</pre>';
//                //        
//                //        die('DEBUG');
//                //
//                $model->insert($values1);
//
//                $account = new Application_Model_Members();
//
//                $vippoint = $account->select()->where('memberId=' . $memberID)->query()->fetch(Zend_Db::
//                    FETCH_OBJ)->vip_points;
//
//
//                $data['vip_points'] = $vippoint + $values['amount'];
//
//                $account->update($data, 'memberID=' . $memberID);
//       
//              $this->_helper->flashMessenger->setNamespace('success')->addMessage("Gift Card Purchased Successfully");
//        
//
//                $this->_redirect("giftcard");
//    
//} else {
//    
//  
//              $this->_helper->flashMessenger->setNamespace('error')->addMessage("Problem with Gift Card Purchase");
//        
//
//                $this->_redirect("giftcard");
//    
//  
//}
//
//
//
//    }
//

    public function indexAction()
    {
        
                        if (! My_Auth::getInstance()->isLoggedIn() ) {
                
              $this->_helper->flashMessenger->setNamespace('error')->addMessage("Login As VIP Member");
        
                    
                 
                $this->_redirect("vipmember");
          
                
            }

        $memberID = My_Auth::getInstance()->getLoggedUser('memberID');
        $model = new Application_Model_Giftcards();

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $result = $db->select()->from(array('gc' => 'gift_cards'))->join(array('u' =>
                'members'), 'gc.memberID=u.memberID', array('u.firstName'))->where('gc.memberID=?',
            $memberID);

        $result = $result->query()->fetchAll(Zend_Db::FETCH_OBJ);


        //  
        //	    echo '<pre>'
        //        print_r(   $result  );
        //        echo '</pre>';   
        //        
        //        die('DEBUG');
        $paginator = Zend_Paginator::factory($result);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
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
