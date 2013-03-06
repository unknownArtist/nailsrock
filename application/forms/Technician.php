<?php

class Application_Form_Technician extends Zend_Form
{

    public function init()
    {


                	$this->setMethod('post');
                  $this->setAction('add-technician');
                  $this->setAttrib('id','addTechnicians');
                    
                  $this->addElement('hidden','technicianID');
                    
                   $name = new Zend_Form_Element_Text('name');
                   $name->setLabel('Technician Name:')
                             ->setFilters(array('StringTrim'))
                    	   ->setRequired(TRUE);
//////////////////////// monday /////////////////////////////////////////////////////
                   $monOpen = new Zend_Form_Element_Text('monOpen');
                   $monOpen->setLabel('Start')
                           ->setValue('9:00 AM')
                           ->setFilters(array('StringTrim'))
                           ->setDecorators(array('ViewHelper'))
                           ->setAttrib('class','timepicker')

                    	 ->setRequired(TRUE);

                   $monClose = new Zend_Form_Element_Text('monClose');
                   $monClose->setLabel('End')
                            ->setValue('8:00 PM')
                            ->setFilters(array('StringTrim'))
                            ->setDecorators(array('ViewHelper'))
                            ->setAttrib('class','timepicker')

                       ->setRequired(TRUE);

                    $monCloseAllDay = new Zend_Form_Element_Checkbox('monCloseAllDay');
                    $monCloseAllDay->setLabel('Mon:')
                    
                        ->setDecorators(array('ViewHelper'))
                        

                       ->setRequired(TRUE);

//////////////////////// tuesday /////////////////////////////////////////////////////
                   $tueOpen = new Zend_Form_Element_Text('tueOpen');
                   $tueOpen->setLabel('Start')
                    ->setValue('9:00 AM')
                    ->setFilters(array('StringTrim'))
                    ->setDecorators(array('ViewHelper'))
                    ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                   $tueClose = new Zend_Form_Element_Text('tueClose');
                   $tueClose->setLabel('End')
                            ->setValue('8:00 PM')
                            ->setFilters(array('StringTrim'))
                            ->setDecorators(array('ViewHelper'))
                            ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                    $tueCloseAllDay = new Zend_Form_Element_Checkbox('tueCloseAllDay');
                    $tueCloseAllDay->setLabel('Tue')
                    
                        ->setDecorators(array('ViewHelper'))

                       ->setRequired(TRUE);


//////////////////////// wednesday /////////////////////////////////////////////////////
                   $wedOpen = new Zend_Form_Element_Text('wedOpen');
                   $wedOpen->setLabel('Start')
                    ->setValue('9:00 AM')
                    ->setFilters(array('StringTrim'))
                    ->setDecorators(array('ViewHelper'))
                    ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                   $wedClose = new Zend_Form_Element_Text('wedClose');
                   $wedClose->setLabel('End')
                    ->setValue('8:00 PM')
                    ->setFilters(array('StringTrim'))
                    ->setDecorators(array('ViewHelper'))
                    ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                    $wedCloseAllDay = new Zend_Form_Element_Checkbox('wedCloseAllDay');
                    $wedCloseAllDay->setLabel('Wed')
                    
                        ->setDecorators(array('ViewHelper'))
                        ->setDecorators(array('ViewHelper'))

                       ->setRequired(TRUE);

//////////////////////// thusday /////////////////////////////////////////////////////
                   $thusOpen = new Zend_Form_Element_Text('thusOpen');
                   $thusOpen->setLabel('Start')
                            ->setValue('9:00 AM')
                            ->setFilters(array('StringTrim'))
                            ->setDecorators(array('ViewHelper'))
                            ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);
                       
                       

                   $thusClose = new Zend_Form_Element_Text('thusClose');
                   $thusClose->setLabel('End')
                   ->setValue('8:00 PM')
                   ->setFilters(array('StringTrim'))
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                    $thusCloseAllDay = new Zend_Form_Element_Checkbox('thusCloseAllDay');
                    $thusCloseAllDay->setLabel('Thus:')
                    
                        ->setDecorators(array('ViewHelper'))

                       ->setRequired(TRUE);

//////////////////////// friday /////////////////////////////////////////////////////
                   $friOpen = new Zend_Form_Element_Text('friOpen');
                   $friOpen->setLabel('Start')
                   ->setValue('9:00 AM')
                   ->setFilters(array('StringTrim'))
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                   $friClose = new Zend_Form_Element_Text('friClose');
                   $friClose->setLabel('End:')
                   ->setValue('8:00 PM')
                   ->setFilters(array('StringTrim'))
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                    $friCloseAllDay = new Zend_Form_Element_Checkbox('friCloseAllDay');
                    $friCloseAllDay->setLabel('Fri')
                    
                        ->setDecorators(array('ViewHelper'))


                       ->setRequired(TRUE);

//////////////////////// saturday /////////////////////////////////////////////////////
                   $satOpen = new Zend_Form_Element_Text('satOpen');
                   $satOpen->setLabel('Start')
                            ->setValue('9:00 AM')
                            ->setFilters(array('StringTrim'))
                            ->setDecorators(array('ViewHelper'))
                            ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                   $satClose = new Zend_Form_Element_Text('satClose');
                   $satClose->setLabel('End')
                   ->setValue('8:00 PM')
                   ->setFilters(array('StringTrim'))
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                    $satCloseAllDay = new Zend_Form_Element_Checkbox('satCloseAllDay');
                    $satCloseAllDay->setLabel('Sat:')
                    
                        ->setDecorators(array('ViewHelper'))

                       ->setRequired(TRUE);

//////////////////////// sunday /////////////////////////////////////////////////////
                   $sunOpen = new Zend_Form_Element_Text('sunOpen');
                   $sunOpen->setLabel('Start:')
                   ->setValue('9:00 AM')
                   ->setFilters(array('StringTrim'))
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                   $sunClose = new Zend_Form_Element_Text('sunClose');
                   $sunClose->setLabel('End:')
                              ->setValue('8:00 PM')
                              ->setFilters(array('StringTrim'))
                              ->setDecorators(array('ViewHelper'))
                              ->setAttrib('class','timepicker')
                       ->setRequired(TRUE);

                    $sunCloseAllDay = new Zend_Form_Element_Checkbox('sunCloseAllDay');
                    $sunCloseAllDay->setLabel('Sun')
                    
                        ->setDecorators(array('ViewHelper'))

                       ->setRequired(TRUE);




                   $add = new Zend_Form_Element_Submit('Add Technician');
                  

            	   $this->addElements(array(
                    $name,
                    $sunCloseAllDay,
                    $sunOpen,
                    $sunClose,
            	   		$monCloseAllDay,
                    $monOpen,
                    $monClose,
                    
                    $tueCloseAllDay,
                    $tueOpen,
                    $tueClose,

                    $wedCloseAllDay,
                    $wedOpen,
                    $wedClose,

                    $thusCloseAllDay,
                    $thusOpen,
                    $thusClose,

                    $friCloseAllDay,
                    $friOpen,
                    $friClose,

                    $satCloseAllDay,
                    $satOpen,
                    $satClose,

                    
                    
                    $add,
            	   		
                    	));

    }
}

