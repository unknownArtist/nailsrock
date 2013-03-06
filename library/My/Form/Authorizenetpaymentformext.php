<?php

class My_Form_Authorizenetpaymentformext extends Zend_Form

{

  

    public function init()

    {



           $this->setAttrib('class','form-horizontal span5');


            $this->setLegend("Buy Gift Card");
     
     
  

        $this->addElement('Text', 'x_amount', array(

            'label' =>  'Gift Card Amount ($)',

            'required' => true,

            'maxlength' => '50',

             'value' => '',
          'filters'=>array('stringTrim'),
            'validators' => array(array('NotEmpty', true), 'Digits'

       ),

            ));
            
            
        $this->addElement('Text','x_first_name', array(

            'label' => 'First Name',

            'required' => true,

            'maxlength' => '20',

            'value' => '',

            'filters'=>array('stringTrim'),

            'validators' => array(array('NotEmpty', true)),

            ));

        

             

        $this->addElement('Text','x_last_name', array(

            'label' => 'Last Name',

            'required' => true,

            'maxlength' => '20',

            'value' => '',

            'filters'=>array('stringTrim'),

            'validators' => array(array('NotEmpty', true), ),

            ));

            
      
        $this->addElement('Text', 'x_email', array(

            'label' => 'Email',

            'required' => true,

            'maxlength' => '50',

            'value' => '',

            'validators' => array(array('NotEmpty', true), 'emailAddress',

 //           array('Db_NoRecordExists',false,array(
//
//            'table'=>'members',
//
//            'field'=>'email'))
            
            ),

            ));
            
        $this->addElement('Text', 'x_address', array(

            'label' => 'Address',

            'required' => true,

            'maxlength' => '50',

            'value' => '',

            'validators' => array(array('NotEmpty', true),    
            ),

            ));

            
                $this->addElement('Text', 'x_city', array(

            'label' => 'City',

            'required' => true,

            'maxlength' => '50',

            'value' => '',

            'validators' => array(array('NotEmpty', true),    
            ),

            ));
        $this->addElement('Text', 'x_state', array(

            'label' => 'State',

            'required' => true,

            'maxlength' => '50',

            'value' => '',

            'validators' => array(array('NotEmpty', true),    
            ),

            ));
    
        $this->addElement('Text', 'x_zip', array(

            'label' => 'Zip',

            'required' => true,

            'maxlength' => '50',

            'value' => '',

            'validators' => array(array('NotEmpty', true),    
            ),

            ));
            
$this->addElement('Text', 'x_phone', array(

            'label' => 'Phone including Area Code',

            'required' => true,

            'maxlength' => '50',

            'value' => '',

            'validators' => array(array('NotEmpty', true),    
            ),

            ));
               
            
        
            
     $this->addElement('Textarea', 'x_description', array(

            'label' => 'Description',

            'required' => true,
            'rows'=>5,
            'cols'=>20,
             'value' => '',
          'filters'=>array('stringTrim'),
            'validators' => array(array('NotEmpty', true), 

       ),

            ));


              // Buttons

        $this->addElement('Button', 'submit', array(

            'label' => 'Buy Gift Card',

            'type' => 'submit',

            'ignore' => true,

            
               'class'=>'btn btn-primary'

            ));

    }

}

