<?php

class Application_Form_Shopcustomhours extends Zend_Form
{

    public function init()
    {
        $this->setAction('shop-custom-hours');
        $this->setMethod('post');
		$this->setAttrib('id','customhours');
     
      
        $option = array(
                            '0' => 'OFF',
                            '1' => 'ON',
                        );

       $date = new Zend_Form_Element_Text('date');
       $date->setLabel('Date:')
                   ->setRequired(FALSE)
                   ->addFilter('StripTags')
                   ->setOptions(array('class'=>'datepicker'))
                   ->addFilter('StringTrim');
       

			
        $closeAllDay = new Zend_Form_Element_Checkbox('closeAllDay');
        $closeAllDay->setLabel('Closed All Day:')
        			->setUncheckedValue(0)
         			->setCheckedValue(1)
         			->setValue(0);                      

        $start = new Zend_Form_Element_Text('shopCustomHoursOpen');
                   $start->setLabel('Time Open:')
                   ->setAttrib('class','timepicker')
      	         ->setRequired(true);
    	 

        $end = new Zend_Form_Element_Text('shopCustomHoursClose');
                  $end->setLabel('Time Close:')
                  ->setAttrib('class','timepicker')
                    	 ->setRequired(FALSE);

        $comments = new Zend_Form_Element_Textarea('comments');
                  $comments->setLabel('Comments:')
                    	 ->setRequired(FALSE)
                         ->setAttrib('COLS', '40')
                         ->setAttrib('ROWS', '4');

 		$submit = new Zend_Form_Element_Submit('Add Custom Closed Day');

        $this->addElements(array(
        				    $date,
   						      $closeAllDay,
            	   		$start,
            	   		$end,
            	   		$comments,
            	   		$submit
            	   		
                    	));



    }

}