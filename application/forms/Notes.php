<?php

class Application_Form_Notes extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post');
           //->setAttrib('id','addNotes');
        $this->setAction('/member/add-notes');
    
        $Notes = new Zend_Form_Element_Text('Notes');
        $Notes->setLabel('Notes:')
                    ->setRequired(TRUE);


 		$submit = new Zend_Form_Element_Submit('Add ');
 		
   	   $this->addElements(array(
       	   		$Notes,
       	   		$submit,
            	   	
                    	));

}
}