<?php

class Application_Form_Giftcardapprove extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post')
           ->setAttrib('id','addReward');
      //  $this->setAction('/member/add-rewardpoint/');
      
      $this->setLegend("Approve Gift Card");
    
    
        $id = new Zend_Form_Element_Hidden('id');
        
        $vipPoints = new Zend_Form_Element_Text('card_no');
         $vipPoints->setLabel(' Insert Gift Card No')
                     ->addFilters(array('stringTrim'))
                    ->setRequired(TRUE);
       
        
       $user_points= new Zend_Form_Element_Text('user_points');
         $user_points->setLabel(' Balance needed($)')
                    ->addValidators(array('Digits'))
                    ->addFilters(array('stringTrim'))
                    ->setRequired(TRUE);
       
       
       
        $note = new Zend_Form_Element_Textarea('note');
        $note->setLabel('Note:')
                    ->setOptions(array('rows'=>5,'cols'=>50))
                    ->setRequired(TRUE);


 		$submit = new Zend_Form_Element_Submit('Approve');
        
 	
   	   $this->addElements(array(
                  $id,
                  $user_points,
                   $vipPoints,
                   $note,
       	   
       	   		$submit,
      	
            	   	
                    	));

}
}