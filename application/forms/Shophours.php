<?php

class Application_Form_Shophours extends Zend_Form
{

    public function init()
    {
        $this->setAction('shop-hours');
        $this->setMethod('post');
		$this->setAttrib('id','addShophours');
        $submit = null;

        $option = array(
                            '0' => 'OFF',
                            '1' => 'ON',
                        );


        //////////////////////// sunday /////////////////////////////////////////////////////
                   $sunOpen = new Zend_Form_Element_Text('sunOpen');
                   $sunOpen->setLabel('Open:')
                           ->setValue('9:00 AM')
                           ->setAttrib('class','timepicker')
                           ->setDecorators(array('ViewHelper'))
                          
                           ->setRequired(FALSE);

                   $sunClose = new Zend_Form_Element_Text('sunClose');
                   $sunClose->setLabel('Close:')
                   ->setValue('8:00 PM')
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                
                       ->setRequired(FALSE);

                    $sunCloseAllDay = new Zend_Form_Element_Checkbox('sunCloseAllDay');
                    $sunCloseAllDay->setLabel('SUN')
                          ->setDecorators(array('ViewHelper'))
                          

                       ->setRequired(FALSE);
        /////////////////////////monday////////////////////////////////////////////////////////

                   $monOpen = new Zend_Form_Element_Text('monOpen');
                   $monOpen->setLabel('Open:')
                   ->setValue('9:00 AM')
                     ->setDecorators(array('ViewHelper'))
                     ->setAttrib('class','timepicker')

                         ->setRequired(FALSE);

                   $monClose = new Zend_Form_Element_Text('monClose');
                   $monClose->setLabel('Close:')
                   ->setValue('8:00 PM')
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                       ->setRequired(FALSE);

                
                    $monCloseAllDay = new Zend_Form_Element_Checkbox('monCloseAllDay');
                    $monCloseAllDay->setLabel('MON')
                      ->setDecorators(array('ViewHelper'))

                      ->setRequired(FALSE);

      //////////////////////// tuesday /////////////////////////////////////////////////////
                   $tueOpen = new Zend_Form_Element_Text('tueOpen');
                   $tueOpen->setLabel('Open:')
                   ->setValue('9:00 AM')
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                       ->setRequired(FALSE);

                   $tueClose = new Zend_Form_Element_Text('tueClose');
                   $tueClose->setLabel('Close:')
                   ->setValue('8:00 PM')
                     ->setDecorators(array('ViewHelper'))
                     ->setAttrib('class','timepicker')

                            ->setRequired(FALSE);

                    $tueCloseAllDay = new Zend_Form_Element_Checkbox('tueCloseAllDay');
                    $tueCloseAllDay->setLabel('TUE')
                      ->setDecorators(array('ViewHelper'))
                       ->setRequired(FALSE);


      //////////////////////// wednesday /////////////////////////////////////////////////////
                   $wedOpen = new Zend_Form_Element_Text('wedOpen');
                   $wedOpen->setLabel('Open:')
                   ->setValue('9:00 AM')
                   ->setDecorators(array('ViewHelper'))
                     ->setAttrib('class','timepicker')
                       ->setRequired(FALSE);

                   $wedClose = new Zend_Form_Element_Text('wedClose');
                   $wedClose->setLabel('Close:')
                   ->setValue('8:00 PM')
                   ->setDecorators(array('ViewHelper'))
                     ->setAttrib('class','timepicker')
                       ->setRequired(FALSE);

                    $wedCloseAllDay = new Zend_Form_Element_Checkbox('wedCloseAllDay');
                    $wedCloseAllDay->setLabel('WED')
                    ->setDecorators(array('ViewHelper'))

                    ->setRequired(FALSE);

    //////////////////////// thursday /////////////////////////////////////////////////////
                   $thusOpen = new Zend_Form_Element_Text('thusOpen');
                   $thusOpen->setLabel('Open:')
                   ->setValue('9:00 AM')
                   ->setDecorators(array('ViewHelper'))
                     ->setAttrib('class','timepicker')
                       ->setRequired(FALSE);

                   $thusClose = new Zend_Form_Element_Text('thusClose');
                   $thusClose->setLabel('Close:')
                             ->setValue('8:00 PM')
                             ->setDecorators(array('ViewHelper'))
                               ->setAttrib('class','timepicker')
                             ->setRequired(FALSE);

                    $thusCloseAllDay = new Zend_Form_Element_Checkbox('thusCloseAllDay');
                    $thusCloseAllDay->setLabel('THUS')
                    ->setDecorators(array('ViewHelper'))    
                    ->setRequired(FALSE);

      //////////////////////// friday /////////////////////////////////////////////////////
                   $friOpen = new Zend_Form_Element_Text('friOpen');
                   $friOpen->setLabel('Open:')
                   ->setValue('9:00 AM')
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                   ->setRequired(FALSE);

                   $friClose = new Zend_Form_Element_Text('friClose');
                   $friClose->setLabel('Close:')
                   ->setValue('8:00 PM')
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                   ->setRequired(FALSE);

                    $friCloseAllDay = new Zend_Form_Element_Checkbox('friCloseAllDay');
                    $friCloseAllDay->setLabel('FRI')
                      ->setDecorators(array('ViewHelper'))
                    

                       ->setRequired(FALSE);

       //////////////////////// saturday /////////////////////////////////////////////////////
                   $satOpen = new Zend_Form_Element_Text('satOpen');
                   $satOpen->setLabel('Open:')
                   ->setValue('9:00 AM')
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')
                       ->setRequired(FALSE);

                   $satClose = new Zend_Form_Element_Text('satClose');
                   $satClose->setLabel('Close:')
                   ->setValue('8:00 PM')
                   ->setDecorators(array('ViewHelper'))
                   ->setAttrib('class','timepicker')

                       ->setRequired(FALSE);

                    $satCloseAllDay = new Zend_Form_Element_Checkbox('satCloseAllDay');
                    $satCloseAllDay->setLabel('SAT')
                      ->setDecorators(array('ViewHelper'))

                       ->setRequired(FALSE);


            $submit = new Zend_Form_Element_Submit('Save Hours');
            $cancel = new Zend_Form_Element_Submit('Cancel');
           

                   $this->addElements(array(

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

                    $submit,
                    $cancel
                    
                    
                        ));

 }

 }