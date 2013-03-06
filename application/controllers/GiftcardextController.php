<?php

class GiftcardextController extends Zend_Controller_Action
{

    public function init()
    {


        require_once 'Authorizenet/AuthorizeNet.php';


        if (!My_Auth::getInstance()->isLoggedIn()) {


        } else {
            $this->_redirect("appointments");

        }


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


    public function addGiftcardAction()
    {


        $form = new My_Form_Authorizenetpaymentformext();
        $model = new Application_Model_Giftcards();


        $this->view->form = $form;

        if (!$this->getRequest()->isPost()) {
            return;
        }

                if ( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }
        $this->renderScript('giftcardext/payment.phtml');
     

    }


    public function confirmGiftcardAction()
    {


        $model = new Application_Model_Giftcards();


        $api_login_id = Zend_Registry::get('api_login_id');
        $transaction_key = Zend_Registry::get('transaction_key');

        $md5_setting = Zend_Registry::get('md5_setting');


        $amount = $_POST['x_amount'];

        $responseVerifyInput = $md5_setting . $api_login_id . $_POST['x_trans_id'] . $amount;

        //  echo md5($responseVerifyInput)." ".$_POST['x_MD5_Hash'];

        //  echo "<br/>".$api_login_id." ".$transaction_key." ".$md5_setting;

        // die ("D");


        if (md5($responseVerifyInput) == strtolower($_POST['x_MD5_Hash'])) {


            // adding web user to site as Non-VIP Member

            $account = new Application_Model_Members();
            $newMember['firstName'] = $_POST['x_first_name'];

            $newMember['lastName'] = $_POST['x_last_name'];

            $newMember['email'] = $_POST['x_email'];

            $newMember['address'] = $_POST['x_address'];
            $newMember['city'] = $_POST['x_city'];
            $newMember['state'] = $_POST['x_state'];

            $newMember['zip_code'] = $_POST['x_zip'];

            $memberID = $account->insert($newMember);


            $values1['points'] = $amount;
            $values1['note'] = $_POST['x_description'];
            $values1['date_created'] = date("Y-m-d", time());


            $values1['memberID'] = $memberID;

            $values1['card_no'] = rand(1111,9999)."-".rand(1111,9999)."-".rand(1111,9999)."-".rand(1111,9999);


            $id = $model->insert($values1);


            //  header("Content-Type: application/x-pdf");
            //   header("Content-Disposition: attachment; filename=giftcard.pdf");
            //  header("Cache-Control: no-cache, must-revalidate");


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

                $to = $newMember['email'];
                $to_name = $newMember['firstName'] . " " . $newMember['lastName'];

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
                $mail->addAttachment($att);
                $mail->send();

                $this->renderScript("giftcard/successext.phtml");


                //    exit(1);


            }
            catch (Zend_Pdf_Exception $e) {
                die('PDF error: ' . $e->getMessage());
            }
            catch (exception $e) {
                die('Application error: ' . $e->getMessage());
            }

            //  exit(1);


            // now download the purchased gift card


            // $this->_helper->flashMessenger->setNamespace('success')->addMessage("Gift Card Purchased Successfully");


            // $this->_redirect("giftcardext");

        } else {


            $this->_helper->flashMessenger->setNamespace('error')->addMessage("Problem with Gift Card Purchase");


            $this->_redirect("giftcardext/add-giftcard");


        }
    }

    public function sendmailAction()
    {
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

            $page->setFont($font, 15)->drawText('Card No: ', 250, 740)->drawText('Card Balance: $',
                250, 720)->drawText('Created By: ', 250, 700)->drawText('Date Created: ', 250,
                680);


            $page->drawText("Phone: 954.360.6888", 200, 650);

            $page->drawText("5913 Lyons Road Coconut Creek, FL.33073", 100, 630);

            // add page to document
            $pdf->pages[] = $page;


            $attachment = $pdf->render();


            $to = "milton.2002@yahoo.com";
            $to_name = "milton";

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

            $this->renderScript("giftcard/successext.phtml");

            //  exit(1);


        }
        catch (Zend_Pdf_Exception $e) {
            die('PDF error: ' . $e->getMessage());
        }
        catch (exception $e) {
            die('Application error: ' . $e->getMessage());
        }


    }


    public function indexAction()
    {


        $this->_redirect("giftcardext/add-giftcard");


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
        $paginator->setDefaultItemCountPerPage(3);
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
