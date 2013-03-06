<?php

class Application_Form_Giftcard extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post')
           ->setAttrib('id','addReward');
      //  $this->setAction('/member/add-rewardpoint/');
    
    
        $id = new Zend_Form_Element_Hidden('id');
        
        $vipPoints = new Zend_Form_Element_Text('x_amount');
         $vipPoints->setLabel(' Gift Card Balance ($)')
                    ->setFilters(array("StringTrim"))
                    ->setValidators(array('NotEmpty','Digits'))
                    ->setRequired(TRUE);
       
        $note = new Zend_Form_Element_Textarea('x_description');
        $note->setLabel('Note:')
                    ->setOptions(array('rows'=>5,'cols'=>50));
                  //  ->setRequired(TRUE);


 		$submit = new Zend_Form_Element_Submit('Add');
        
 	
   	   $this->addElements(array(
                  $id,
                   $vipPoints,
       	   		$rewardPoints,
                $note,
                $type,
       	   		$submit,
      	
            	   	
                    	));

}
}