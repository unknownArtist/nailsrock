<?php

class Application_Form_Viprewardhistory extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post')
           ->setAttrib('id','addReward');
        $this->setAction('/member/add-rewardhistory/');
    
    
        $id = new Zend_Form_Element_Hidden('id');
        $rewardPoints = new Zend_Form_Element_Text('rewardPoints');
        $rewardPoints->setLabel('Reward Amount:')
                    ->setRequired(TRUE);

        $note = new Zend_Form_Element_Textarea('note');
        $note->setLabel('Note:')
                    ->setOptions(array('rows'=>5,'cols'=>50));
                 //   ->setRequired(TRUE);


 		$submit = new Zend_Form_Element_Submit('Add');
        
 		$substract  = new Zend_Form_Element_Submit('Substract ');
 		
 		
   	   $this->addElements(array(
                  $id,
       	   		$rewardPoints,
                $note,
                $type,
       	   		$submit,
            	$substract
            	   	
                    	));

}
}