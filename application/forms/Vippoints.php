<?php

class Application_Form_Vippoints extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post')
           ->setAttrib('id','addReward');
        $this->setAction('/member/add-rewardpoint/');
    
    
        $id = new Zend_Form_Element_Hidden('id');
        
        $vipPoints = new Zend_Form_Element_Text('member_ref');
         $vipPoints->setLabel(' VIP #')
                    ->setRequired(TRUE);
                    
        $rewardPoints = new Zend_Form_Element_Text('rewardPoints');
        $rewardPoints->setLabel('Reward Amount:')
                    ->setRequired(TRUE);
        $note = new Zend_Form_Element_Textarea('note');
        $note->setLabel('Note:')
                    ->setOptions(array('rows'=>5,'cols'=>50));
                    


 		$submit = new Zend_Form_Element_Submit('Add');
        
 		$subtract  = new Zend_Form_Element_Submit('Subtract ');
 		
 		
   	   $this->addElements(array(
                  $id,
                   $vipPoints,
       	   		$rewardPoints,
                $note,
                $type,
       	   		$submit,
            	$subtract
            	   	
                    	));

}
}