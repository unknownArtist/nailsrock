<?php

class Application_Form_Editaccount extends Zend_Form
{

    public function init()
    {
        
        
        
        
        $this->setAttrib('id', 'event_create_form')
      ->setMethod("POST")
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));


    $this->addElement('Text', 'vipMemberCard', array(
      'label' => 'VIP Member Card:',

      'filters'=>array('StringTrim'),
      'validators' => array(
        array('NotEmpty', true),
    
      ),
    ));

   // Title
    $this->addElement('Text', 'email', array(
      'label' => '*Email:',
     // 'description'=>'Select date that this invitation code will be valid until (yyyy-mm-dd)',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
  //      array('emailAddress'),
//        array('Db_RecordExists',true, array( 
//        
//        'table' => 'members',
//        'field' => 'email'))
      ),
      
    //  'description'=>'You will use your email address to login'
  
    ));


    
      
    // Title
    $this->addElement('Password', 'password', array(
      'label' => '*Password:',
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
    $this->addElement('Password', 'repassword', array(
      'label' => '*Confirm Password:',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
         array('identical', false, array('token' =>$password,'strict'=>false ))
      
      ),
       'value'=>''
       
       
      
   
    ));
    


    // Title
    $this->addElement('Text', 'firstName', array(
      'label' => '*First Name:',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('StringTrim'),
      'validators' => array(
        array('NotEmpty', true),
    
      ),
    ));

  // Title
    $this->addElement('Text', 'lastName', array(
      'label' => '*Last Name:',
      'allowEmpty' => false,
      'required' => true,
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ),
    ));

    $this->addElement('Text', 'phone', array(
      'label' => 'Phone:',
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ), 'Digits'
    ));

  
    $this->addElement('Text', 'address', array(
      'label' => 'Address 1:',
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ),
    ));
    
    
    $this->addElement('Text', 'city', array(
      'label' => 'City:',
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ),
    ));     
        
    $this->addElement('Text', 'state', array(
      'label' => 'State:',
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ),
    )); 
        
    $this->addElement('Text', 'zip_code', array(
      'label' => 'Zip:',
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ),
    ));  
        
        
        $vip = array(
           2   =>  "No",
            1   =>  "Yes",
           
          );

//


   $VipMember = new Zend_Form_Element_Select('vipMember');
                   $VipMember->setLabel('VIP Member')
                             ->addMultiOptions($vip)
                             ->setValue('n');

$this->addElement($VipMember);



    // Buttons
    $this->addElement('submit', 'submit', array(
      'label' => 'Save',
      'type' => 'submit',
      'ignore' => true,
      'class'=>'submit',
      'decorators'=>array('ViewHelper')
    ));

    $this->addElement('reset', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
    
  'decorators'=>array('ViewHelper'),
      'class'=>'reset'
    ));

       
     
    }
}

