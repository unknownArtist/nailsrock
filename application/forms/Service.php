<?php

class Application_Form_Service extends Zend_Form
{

    public function init()
    {
        
         $Appointment_time_durations=new Application_Model_Appointmenttimeduration ();
         $Appointment_times=$Appointment_time_durations->fetchAll(Zend_Db::FETCH_OBJ);
         
                $rows=$Appointment_times;
            
	       foreach ($rows as $row) {
	           $options[$row->duration]=$row->duration." Minutes";
     //                      
//	    echo '<pre>';
//        print_r(   $options );
//        echo '</pre>';
//        
//        die('DEBUG');
           }
       
        
        $services = array(

            '15 Minutes'    =>    '15 Minutes',
            '45 Minutes'    =>    '45 Minutes',
            '60 Minutes'    =>    '60 Minutes',
            );

    	$this->setMethod('post');
        $this->setAction('add-services');
        $this->setAttrib('id','addServices');


        $serviceName = new Zend_Form_Element_Text('serviceName');
        $serviceName->setLabel('Service Name:')
                    ->setRequired(TRUE);

        $duration = new Zend_Form_Element_Select('duration');
        $duration->setLabel('Service Time:')
        		 ->addMultiOptions($options)
                 ->setRequired(TRUE);


 		$submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Add Service');
        $submit->setAttrib('class','serviceslogin');
        
        $serviceID=new Zend_Form_Element_Hidden('serviceID');
 		
   	   $this->addElements(array(
                $serviceID,
       	   		$serviceName,
       	   		$duration,
       	   		$submit,
             
             
   
            	   	
                    	));

    }
}