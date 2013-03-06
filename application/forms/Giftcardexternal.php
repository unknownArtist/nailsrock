<?php

class Application_Form_Giftcardexternal extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post')
           ->setAttrib('id','addReward');
      //  $this->setAction('/member/add-rewardpoint/');
      // Title
    $this->addElement('Text', 'points', array(
      'label' => 'Card Balance:',
      'allowEmpty' => false,
      'required' => true,
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
        array('emailAddress'),
        array('Db_NoRecordExists',true, array( 
        
        'table' => 'members',
        'field' => 'email'))
      ),
      
    //    'description'=>'You will use your email address to login'
  
    ));

    //  
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

 $this->addElement('Text', 'phCode', array(
      'label' => 'Phone Code:',
      'filters'=>array('stringTrim'),
      'validators' => array(
        array('NotEmpty', true),
      
      ), 'Digits'
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
        
    $this->addElement('Submit','submit',array(
            'lable'=>'Submit',
    
            ));
            
    
            
            
            
}
}