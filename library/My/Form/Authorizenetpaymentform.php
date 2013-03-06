<?php

class My_Form_Authorizenetpaymentform extends Zend_Form

{

  

    public function init()

    {



           $this->setAttrib('class','form-horizontal span5');


     

        $this->addElement('Text','first_name', array(

            'label' => 'First Name',

            'required' => true,

            'maxlength' => '20',

            'value' => '',

            'filters'=>array('stringTrim'),

            'validators' => array(array('NotEmpty', true)),

            ));

        

             

        $this->addElement('Text','last_name', array(

            'label' => 'Last Name',

            'required' => true,

            'maxlength' => '20',

            'value' => '',

            'filters'=>array('stringTrim'),

            'validators' => array(array('NotEmpty', true), ),

            ));

            

               

        $this->addElement('Text','card_num', array(

            'label' => 'Credit Card Number',

           // 'description'=>'Including Country Code prepending +',

            'required' => true,

            'maxlength' => '20',

            'value' =>'' ,

            'filters'=>array('stringTrim'),

            'validators' => array(array('NotEmpty', true),'Digits' ),

            ));

            

        $this->addElement('Text', 'exp_date', array(

            'label' => 'Expiry Date',

            'required' => true,

            'maxlength' => '50',

             'value' => '',
          'filters'=>array('stringTrim'),
            'validators' => array(array('NotEmpty', true), 

       ),

            ));
            
                  $this->addElement('Text', 'card_code', array(

            'label' => 'CVV',

            'required' => true,

            'maxlength' => '50',

             'value' => '',
          'filters'=>array('stringTrim'),
            'validators' => array(array('NotEmpty', true), 

       ),

            ));  
            

  

        $this->addElement('Text', 'amount', array(

            'label' =>  'Gift Card Amount ($)',

            'required' => true,

            'maxlength' => '50',

             'value' => '',
          'filters'=>array('stringTrim'),
            'validators' => array(array('NotEmpty', true), 

       ),

            ));
            
            
            
            
        $this->addElement('Text', 'email', array(

            'label' => 'Email',

            'required' => true,

            'maxlength' => '50',

            'value' => '',

            'validators' => array(array('NotEmpty', true), 'emailAddress',

  //          array('Db_NoRecordExists',false,array(
//
//            'table'=>'users',
//
//            'field'=>'email'))
//            
//            
            
            ),

            ));

            
            
            
        $this->addElement('Textarea', 'address', array(

            'label' => 'Address',

            'required' => true,
            'rows'=>5,
            'cols'=>20,
             'value' => '',
          'filters'=>array('stringTrim'),
            'validators' => array(array('NotEmpty', true), 

       ),

            ));

     $this->addElement('Textarea', 'note', array(

            'label' => 'Note',

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

