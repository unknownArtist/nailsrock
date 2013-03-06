<?php

class Application_Form_Memberappointment extends Zend_Form
{

    public function init()
    {
        $code = array(

            '(954)'    =>    '954',
            '(754)'    =>    '754',
            '(561)'    =>    '561',
             '(305)'    =>    '305',
              '(786)'    =>    '786',
              ''=>'N/A'
            );

    	$this->setMethod('post');
        $this->setAction('');
        //$this->setAttrib('id','addServices');
        
        
//               
// $this->addElement('select', 'memberID', array(
//            'required' => true,
//            'label'    => 'Or Select:',
//             'decorators' => array(
//        'ViewHelper', 'Label'
//      ),
//           
//             'class'=>'dropdown'
//        ));

    $this->addElement('text', 'memberID', array(
            'required' => true,
            'label'    => 'Or Select:',
            'class'=>'reset',
             'decorators' => array(
        'ViewHelper', 'Label'
      ),
           
        ));
            
     
    // Buttons
    $this->addElement('Reset', 'clear', array(
      'label' => 'Reset for New Customer',
      'type' => 'Reset',
      'ignore' => true,
      'decorators' => array(
        'ViewHelper',
      ),
    ));
    
    
  
$date=date('m-d-y', time());


if ( My_Auth::getInstance()->isVIPMember()) {
   
$date= date('m-d-y', strtotime('+1 day'));

	}    
        $this->addElement('Text','date', array(
            'label' => 'Date:',
            'required' => true,
            'class'=>'date',
        
            'filters'=>array('stringTrim'),
            'validators' => array(array('NotEmpty', true)),
            'value'=>  $date
      
            ));
        $this->addElement('Text','firstName', array(
            'label' => 'First Name:',
            'required' => true,

            'filters'=>array('stringTrim'),
            'class'=>'reset',
            'validators' => array(array('NotEmpty', true)),
            'decorators'=>array('ViewHelper', 'Label')
            ));
        
        $this->addElement('Text','lastName', array(
          //  'label' => 'Last Name:',
            'required' => true,
            'filters'=>array('stringTrim'),
            'class'=>'reset',
            'validators' => array(array('NotEmpty', true)),
            ));
        
 $this->addElement('select', 'phCode', array(
            'required' => true,
            'multiOptions' =>$code,
             'class'=>'reset',
              'decorators'=>array('ViewHelper', 'Label')
             
        ));

        
       
        $this->addElement('Text','phone', array(
            //'label' => '',
            'required' => true,
            'filters'=>array('stringTrim'),
            'validators' => array(array('NotEmpty', true),'digits'),
            'class'=>'reset',
             'decorators'=>array('ViewHelper')
            ));          
                 

         
 $this->addElement('select', 'serviceID', array(
            'required' => true,
            'label'    => 'Service:',
            'multiOptions' =>$code,
             'class'=>'dropdown'
        ));

        

    }
}