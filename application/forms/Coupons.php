<?php

class Application_Form_Coupons extends Zend_Form
{

    public function init()
    {
        $this->setAction('coupons');
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('id','coupon');

        //$path = new Zend_Form_Element_Text('path');
        //Zend_Debug::dump($fullFilePath);

        $file = new Zend_Form_Element_File('file');
        $file->setLabel('Upload Coupon :')
            // ->setRequired(true)
             ->setDestination(APPLICATION_PATH.'/../public/coupons')
             ->addFilter(new Zend_Filter_File_Rename(array('target' => 'coupon.pdf')))
             ->addValidator('NotEmpty');



        $vipfile = new Zend_Form_Element_File('vipfile');
        $vipfile->setLabel('VIP Member Coupon :')
          //   ->setRequired(true)
             ->setDestination(APPLICATION_PATH.'/../public/coupons/')
               ->addFilter(new Zend_Filter_File_Rename(array('target' => 'vip-coupon.pdf')))
             ->addValidator('NotEmpty');


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Upload Coupon');

        

        $this->addElements(array($file, $vipfile, $submit));

            



    } 

     
    


}