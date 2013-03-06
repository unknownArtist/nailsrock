<?php

/**
 * @author lolkittens
 * @copyright 2012
 */

<?php

class Application_Form_Account extends Zend_Form
{

    public function init()
    {
        
        
        
        
        $this->setTitle('Create Account')
      ->setAttrib('id', 'event_create_form')
      ->setMethod("POST")
      ->setOptions(array('Description'=>"You are retail professional and you want to join yelloRetail,
      But you don't have invitation code? No problem, just fill in the form to request one"))
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    // Title
    $this->addElement('Text', 'f_name', array(
      'label' => 'First Name',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('StringTrim'),
      'validators' => array(
        array('NotEmpty', true),
    
      ),
       'value' => 0,
      
    //  'description'=>'Enter unique invitation Code '
    ));

  // Title
    $this->addElement('Text', 'l_name', array(
      'label' => 'Last Name',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ),
      //'multiOptions'=>array('Super Admins','Admins','Moderators','Default Level','Public'),
      
      //'description'=>'Select user role to be assigned to users signup with this code '
    ));


   // Title
    $this->addElement('Text', 'email', array(
      'label' => 'Email Address',
      'description'=>'Select date that this invitation code will be valid until (yyyy-mm-dd)',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
        array('emailAddress'),
        array('Db_RecordExists',false, array( 
        
        'table' => 'engine4_invitationuser_requestcode',
        'field' => 'email'))
      ),
      
      'description'=>'You will use your email address to login'
  
    ));
 
    
   // Title
  //  $this->addElement('Text', 'username', array(
//      'label' => 'User Name',
//      'description'=>'',
//      'allowEmpty' => false,
//      'required' => true,
//      'validators' => array(
//        array('NotEmpty', true),
//        array('emailAddress'),
//        array('Db_RecordExists',false, array( 
//        
//        'table' => 'engine4_users',
//        'field' => 'username'))
//      ),//
      
     
  
  //  ));
     $codeTable= Engine_Api::_()->getDbtable('globalsettings', 'invitationuser');
  
    $db=$codeTable->getAdapter();
    
    $countries=$db->select()->from('engine4_invitationuser_country')->query()->fetchAll( Zend_Db::FETCH_OBJ );
     
     $rows=$countries;
         if (is_array($rows)) {
            
	       foreach ($rows as $row) {
	           $options[$row->name]=$row->name;
           }
         }      
//	    echo '<pre>';
//        print_r(  $options   );
//        echo '</pre>';
//        
//        die('DEBUG');
   // Title
    $this->addElement('Select', 'country', array(
      'label' => 'Country',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 64)),
      ),
       'multiOptions'=>$options,
     
      
    ));


    // Title
    $this->addElement('Text', 'company', array(
      'label' => 'Company',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 64)),
      ),
      
    //  'description'=>'Enter unique invitation Code '
    ));
    
    // Title
    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ),
      
    //  'description'=>'Enter unique invitation Code '
    ));
    
      
    // Title
    $this->addElement('Text', 'password', array(
      'label' => 'Password',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      ),
      'value'=>''
 
    ));
    
    if ( $password= $_POST['password'] ) {
        //	echo $password;
   // die ('DEBUG');
    }
         
    // Title
    $this->addElement('Text', 'repassword', array(
      'label' => 'Confirm Password',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
         array('identical', false, array('token' =>$password,'strict'=>false ))
      
      ),
       'value'=>''
      
   
    ));
    
    
  // now adding captcha
       
     // Search
    $this->addElement('Hidden', 'language', array(
      'Description' => 'People can search for this event',
      'value' => 'English'
    ));
    
      
     // Search
    $this->addElement('Text', 'invitation_code', array(
    'label'=>'Invitation Code',
      
      'value' => 0,
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
         array('Db_RecordExists',false, array( 
        
        'table' => 'engine4_invitationuser_codes',
        'field' => 'invitation_code'))
    
      ),
      
      
      
    ));
    
      
                // Element: timezone
  $this->addElement('Select', 'timezone', array(
      'label' => 'User Timezone',
      'multiOptions' => array(
        'US/Pacific' => '(UTC-8) Pacific Time (US & Canada)',
        'US/Mountain' => '(UTC-7) Mountain Time (US & Canada)',
        'US/Central' => '(UTC-6) Central Time (US & Canada)',
        'US/Eastern' => '(UTC-5) Eastern Time (US & Canada)',
        'America/Halifax' => '(UTC-4)  Atlantic Time (Canada)',
        'America/Anchorage' => '(UTC-9)  Alaska (US & Canada)',
        'Pacific/Honolulu' => '(UTC-10) Hawaii (US)',
        'Pacific/Samoa' => '(UTC-11) Midway Island, Samoa',
        'Etc/GMT-12' => '(UTC-12) Eniwetok, Kwajalein',
        'Canada/Newfoundland' => '(UTC-3:30) Canada/Newfoundland',
        'America/Buenos_Aires' => '(UTC-3) Brasilia, Buenos Aires, Georgetown',
        'Atlantic/South_Georgia' => '(UTC-2) Mid-Atlantic',
        'Atlantic/Azores' => '(UTC-1) Azores, Cape Verde Is.',
        'Europe/London' => 'Greenwich Mean Time (Lisbon, London)',
        'Europe/Berlin' => '(UTC+1) Amsterdam, Berlin, Paris, Rome, Madrid',
        'Europe/Athens' => '(UTC+2) Athens, Helsinki, Istanbul, Cairo, E. Europe',
        'Europe/Moscow' => '(UTC+3) Baghdad, Kuwait, Nairobi, Moscow',
        'Iran' => '(UTC+3:30) Tehran',
        'Asia/Dubai' => '(UTC+4) Abu Dhabi, Kazan, Muscat',
        'Asia/Kabul' => '(UTC+4:30) Kabul',
        'Asia/Yekaterinburg' => '(UTC+5) Islamabad, Karachi, Tashkent',
        'Asia/Dili' => '(UTC+5:30) Bombay, Calcutta, New Delhi',
        'Asia/Katmandu' => '(UTC+5:45) Nepal',
        'Asia/Omsk' => '(UTC+6) Almaty, Dhaka',
        'Indian/Cocos' => '(UTC+6:30) Cocos Islands, Yangon',
        'Asia/Krasnoyarsk' => '(UTC+7) Bangkok, Jakarta, Hanoi',
        'Asia/Hong_Kong' => '(UTC+8) Beijing, Hong Kong, Singapore, Taipei',
        'Asia/Tokyo' => '(UTC+9) Tokyo, Osaka, Sapporto, Seoul, Yakutsk',
        'Australia/Adelaide' => '(UTC+9:30) Adelaide, Darwin',
        'Australia/Sydney' => '(UTC+10) Brisbane, Melbourne, Sydney, Guam',
        'Asia/Magadan' => '(UTC+11) Magadan, Solomon Is., New Caledonia',
        'Pacific/Auckland' => '(UTC+12) Fiji, Kamchatka, Marshall Is., Wellington',
      ),

     
    ));
    
    
       $globalsettingsTable =Engine_Api::_()->getDbtable('globalsettings', 'invitationuser');
    $globalsettings=$globalsettingsTable->find(1)->current();
    
    //       recaptcha_enabled 	recaptcha_api 
    
    $recaptcha_enabled=$globalsettings->recaptcha_enabled;
    $recaptcha_api_public=$globalsettings->recaptcha_api_public;
    $recaptcha_api_private=$globalsettings->recaptcha_api_private;
    
    
    if ( $recaptcha_enabled ) {
        
        
        $recaptcha = new Zend_Service_ReCaptcha($recaptcha_api_public, $recaptcha_api_private);
        $captcha = $this->createElement('Captcha', 'ReCaptcha',
	                array('captcha'=>array('captcha'=>'ReCaptcha',
	                                        'service'=>$recaptcha)));
	 
       $captcha->setLabel('Enter CAPTCHA');
       $this->addElement($captcha);
	 
        
    }
    
function url(){
  $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}
//	echo url();
   // die ('DEBUG');

    
 //   Zend_Form_element_
    
     // Search
    $this->addElement('Checkbox', 'agree', array(
   
      'Description'=>'I have read and agree to the <a herf="http://localhost/ahmet/site/invitationuser/user/terms" class="smoothbox"><b>Terms of Service</b></a>',
      'value' => 1,
      'label'=>' ',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),

    ));
    $ViewScript=  dirname(__FILE__).'/../views/scripts/user/terms.tpl';
    

    // OR specifying the viewScript as an element attribute:
$this->agree->viewScript = 'user/termsview.tpl';
$this->agree->setDecorators(array(array('ViewScript',
                                    array('class' => 'form element'))));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'decorators' => array(
        'ViewHelper',
      ),
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
      'decorators' => array(
        'FormElements',
        'DivDivDivWrapper',
      ),
    ));
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        $vip = array(
            '1'   =>  "Yes",
            '0'   =>  "No"
          );


                	$this->setMethod('post')
                       ->setAction('')
                       ->setAttrib('id','addServices');


                   $VipMember = new Zend_Form_Element_Select('VipMember');
                   $VipMember->setLabel('VIP Member')
                             ->addMultiOptions($vip);
                              
                    

                   $email = new Zend_Form_Element_Text('email');
                   $email->setLabel('Email:')
                    	 ->setRequired(TRUE);

                   $password = new Zend_Form_Element_Password('password');
                   $password->setLabel('Enter Password:')
                    	    ->setRequired(TRUE);

                   $password1= new Zend_Form_Element_Password('password1');
                   $password1->setLabel('Confirm Password:')
                   			 ->addValidator('identical', false, array('token' => 'password'))
                    	   ->setRequired(TRUE);


                   $firstName = new Zend_Form_Element_Text('firstName');
                   $firstName->setLabel('First Name:')
                    	     ->setRequired(TRUE);

                   $lastName = new Zend_Form_Element_Text('lastName');
                   $lastName->setLabel('Last Name:')
                    	    ->setRequired(TRUE);


                   $phone = new Zend_Form_Element_Text('phone');
                   $phone->setLabel('Phone:')
                    	 ->setRequired(FALSE);

                   $address = new Zend_Form_Element_Text('address');
                   $address->setLabel('Address 1:')
                    	 ->setRequired(FALSE);


                   $city = new Zend_Form_Element_Text('city');
                   $city->setLabel('City:')
                    	->setRequired(FALSE);

                   $state = new Zend_Form_Element_Text('state');
                   $state->setLabel('State:')
                    	 ->setRequired(FALSE);

                   $zip_code = new Zend_Form_Element_Text('zip_code');
                   $zip_code->setLabel('Zip Code:')
                    	 ->setRequired(FALSE);
                 
                   $add = new Zend_Form_Element_Submit('Add');
                  

            	   $this->addElements(array(
            	   		
            	   		

            	   // $this->addElement('password', 'password', array('label' => 'Password:'));
            	   // $this->addElement('password', 'password2', array('label' => 'Confirm Password:',
            		  //   			  'validators' => array(
            		  //       		   array('identical', false, array('token' => 'password'))
            		  //  				  )
            				// 		  ));
                   
                    $email,
            	   		$password,
            	   		$password1,
            	   		$firstName,
            	   		$lastName,
            	   		$phone,
            	   		$address,
            	   		$city,
            	   		$state,
            	   		$zip_code,
                    $VipMember,                    
            	   		$add,
            	   		
                    	));

    }
}



?>