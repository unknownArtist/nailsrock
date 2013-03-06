<?php

class AppointmentsController extends Zend_Controller_Action
{

    public function init()
    { //

        /* Initialize action controller here */
       if ( My_Auth::getInstance()->isVIPMember() || My_Auth::getInstance()->isAdmin()  ) {

        //  $this->_redirect('/appointments/index');
	   } else {
           
    //$this->_helper->FlashMessenger->setNamespace('warning')->addMessage('Access Denied');
        
           $this->_redirect('/');
    }
        
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('loadcustomer', 'json')
        ->addActionContext('makeappointment','json')
        ->initContext();


    }
public function pointsAction(){
	
    $this->view->form=new Application_Form_Vippoints();
    
         $reward = new Application_Model_Viprewardshistory();
         $db=$reward->getAdapter();
         
         $r_data=$db->select()->from(array('v'=>'viprewardshistory'))
                            ->join(array('m'=>'members'),'m.memberID=v.memberID','firstName')
                            ->order('v.date DESC')
                            ->query()->fetchAll(Zend_Db::FETCH_ASSOC);
       
         
         
                           $paginator = Zend_Paginator::factory($r_data);   
                  $paginator->setCurrentPageNumber($this->_getParam('page',1));  
                  $paginator->setDefaultItemCountPerPage(15);
                   $this->view->r_data = $paginator;
}








public function getAppointment($id){
	
    
        $service=$this->_getParam('serviceID');
        $Technician = new Application_Model_Technician();
        $services = new Application_Model_Services();
        $members = new Application_Model_Members();
        $form = new Application_Form_Memberappointment();
        $appointments = new Application_Model_Appointments();
        $TechResHours = new Application_Model_TechnicianReservedHours();
        $AllTechnicalHours = new Application_Model_Alltechnicianhours();
        
        $Technicianhours = new Application_Model_Technicianhours();
                    
                      
        $Technicianservices = new Application_Model_Technicianservices();
                   
    
                    $db= $appointments->getDefaultAdapter();
                    $oldappointment=$db->select()
                                    ->from(array('a'=>'appointments'))
                                     ->join(array('s'=>'services'),'s.serviceID=a.serviceID',array('*'))
                                     ->join(array('m'=>'members'),'m.memberID=a.memberID',array('*'))
                              
                                    ->where('a.id=?', $id)
                                    ->query()
                                    ->fetch(Zend_db::FETCH_OBJ)
                                    ;
 
                    
                              
               $oldappointment->reserved_hours= $db->select()
                                    ->from(array('trh'=>'technician_reserved_hours'))
                                    ->join(array('atchr'=>'alltechnicianhours'),'trh.time_id=atchr.id',array('interval_time'))
                                    ->join(array('t'=>'technician'),'t.technicianID=trh.technicianID',array('Name'))

                                    ->where('trh.appointment_id=?', $id)
                                    ->query()
                                    ->fetch(Zend_db::FETCH_OBJ)
                                    ; 
               
	   return $oldappointment;
}
public function USAToMySQLDate($usa_date){
    
	list($m,$d,$y)=explode('-',$usa_date);
        
      return  $date="20".$y."-".$m."-".$d;
}
public function MySQLToUSADate($mysql_date){
    
	list($y,$m,$d,)=explode('-',$mysql_date);
        
      return  $date=$m.'-'.$d.'-'.substr($y,-2,2);
}

public function loadtechnitiantableAction(){
    
      

    
    $min=date ('m');
    
    if ( ($min%15)!=0 ){
        
        while ( 1 )
                  {
                    
                        if ( ($min%15)==0 ){
                            
                            break;
                        }   
                        $min++;
                  }  
    }
    
 //   echo $min;
    
    $current_time=date ('G:').$min.date ('a');
    
    $current_time_id=$this->timeToTimeID( $current_time );

    $this->view->current_time_id=$current_time_id;
    
    
     $this->_helper->layout->disableLayout();
    
            $Technician = new Application_Model_Technician();
        $services = new Application_Model_Services();
        $members = new Application_Model_Members();
        $form = new Application_Form_Memberappointment();
        $appointments = new Application_Model_Appointments();
        $TechResHours = new Application_Model_TechnicianReservedHours();
        $AllTechnicalHours = new Application_Model_Alltechnicianhours();
        
        $Technicianhours = new Application_Model_Technicianhours();   
                      
        $Technicianservices = new Application_Model_Technicianservices();
           

        
        $date=self::USAToMySQLDate($this->_getParam('date'));
        
        $this->view->date=$date;
        
        //	echo $_POST['date']." ".$date;
   // die ('DEBUG');
        
        $service=$this->_getParam('serviceID');
        
        $current_appointment_id=$this->_getParam('current_appointment_id');
        if ($current_appointment_id) {
            
            
                    $current_appointment=self::getAppointment(  $current_appointment_id );

        $this->view->current_appointment=$current_appointment;
         $this->view->appoint_id_edit=$current_appointment;
        }

        


    $appoint_id_edit=$this->_getParam('appoint_id_edit');
    
    if ( isset($appoint_id_edit) ) {
        $this->view->appoint_id_edit=$appoint_id_edit;
    }
    
    
    
    

        $ShopHours = new Application_Model_Shophours();

        $ShopCustomHours = new Application_Model_Shopcustomhours();

        $membersArr = $this->view->members = $members->fetchAll()->toArray();

        $servicesArr = $this->view->services = $services->fetchAll()->toArray();

        $AllTechnicalHoursValues = $AllTechnicalHours->fetchAll()->toArray();

        foreach ($AllTechnicalHoursValues as $row)
        {
            $AllTechnicalHoursArr[$row['id']] = $row['interval_time'];
        }

        //print_r($AllTechnicalHoursArr );

        $this->view->AllTechnicalHours = $AllTechnicalHoursArr;
        
// some chnages when user is vip member



        $appointmentsArr = $appointments->fetchAll()->toArray();
        
        $this->view->TechResHours = $TechResHours->fetchAll()->toArray();
 
        $rows = $servicesArr;
        if (is_array($rows))
        {
          $servicesOptions[null]="Select Service";
            
            foreach ($rows as $row)
            {
                $servicesOptions[$row['serviceID']] = $row['serviceName']." ".$row['duration']." Min";
                     
            }
        }
 
    $form->serviceID->setMultiOptions($servicesOptions);
  
        $this->view->form=$form;
        
        if (!$date)
        {
            return;
        }

// die('DEBUG');
// checking shop custom hours for date
//          ID 	day 	date 	closeAllDay 	start 	end 	comments 

        $dayshopHours = $ShopCustomHours->select()->where("date=?", $date)->query()->
            fetch(Zend_Db::FETCH_OBJ);
            

if ( $dayshopHours ) {
    
    
        if (!$dayshopHours->closeAllDay) {
            
            
        $dayStart = $dayshopHours->start;

        $dayEnd = $dayshopHours->end;
        } else {
            die ("closed");
        }
        

	} else {

// find dAy for the date


$day=date('l', strtotime($date) );

$shophour=$ShopHours->select()
                ->where('day=?',$day)
                ->where('closeAllday=1')
                ->query()
                ->fetch(Zend_Db::FETCH_OBJ);
if ($shophour) {
    
       
	  $dayStart=$shophour->open;
      $dayEnd=$shophour->close;
}else {
    echo "Day's operation is closed";
    
    die ('');
}
      
     // echo $dayStart." ".$dayEnd." ".$day;
     // die ("f");

}



        $starttimeId = $AllTechnicalHours->select()->where("interval_time=?", $dayStart)->
            query()->fetch(Zend_Db::FETCH_OBJ)->id;


        $endtimeId = $AllTechnicalHours->select()->where("interval_time=?", $dayEnd)
        ->query()->fetch(Zend_Db::FETCH_OBJ)->id;

        $AllTechnicalHoursfordate = $AllTechnicalHours->select()->limit($endtimeId - $starttimeId +
            1, $starttimeId - 1)->query()->fetchAll(Zend_Db::FETCH_OBJ);



         $this->view->AllTechnicalHoursfordate =  $AllTechnicalHoursfordate;


        $db = $ShopCustomHours->getAdapter();
        
        
        
         $this->view->Technician = $Technician->fetchAll()->toArray();


        $TechniciansAvailable = array();
        $TechniciansArr=$Technician->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
                                   // ->join('technicianservices','technicianservices.technicianID=technician.technicianID',array(''))
                                   // ->where('technicianservices.serviceID='.$service)
                                    ->query()
                                    ->fetchAll(Zend_Db::FETCH_ASSOC);
     
     $past_appointment_ids=array();
            foreach ($TechniciansArr as $Technician_row)
    
        {

                $TechnicianId = $Technician_row['technicianID'];
           

              foreach ($AllTechnicalHoursfordate as $time_obj)
            {
            $Time_id = $time_obj->id;
            $interval_time=$this->timeConversion12hTO24h($time_obj->interval_time).":00";
            $reserved_tech_member = array();

              
              
              
            if ( !$TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['status']  ){
                               $techserviceavailble= $Technicianservices->select()->where('technicianID='.$TechnicianId);
                               
                               
                               if ( $service ){
                                $techserviceavailble= $techserviceavailble->where('serviceID='.$service);
                                $this->view->no_service_selected=1;
                               }
                                   
                                     $techserviceavailble= $techserviceavailble->query()
                                            ->fetchAll(Zend_Db::FETCH_OBJ);
                                     
                      
                      
                if ( $techserviceavailble ) {
                  
                     $day=date('l',strtotime($date));
       

                    $db= $appointments->getDefaultAdapter();
                    $appointment=$db->select()
                                    ->from(array('a'=>'appointments'))
                                    ->join(array('r'=>'technician_reserved_hours'),'a.id=r.appointment_id')
                                    ->join(array('atchr'=>'alltechnicianhours'),'r.time_id=atchr.id',array('interval_time'))
                                     ->join(array('s'=>'services'),'s.serviceID=a.serviceID',array('*'))
                                    ->where('a.date=?', $date)
                                    ->where('r.technicianID=?',$TechnicianId)
                                    ->where('r.time_id=?',$Time_id) ;
                        
        
           //                if ( My_Auth::getInstance()->isVIPMember() ){
//
//                                     $vipMemberId=My_Auth::getInstance()->getLoggedUser('memberID');
//                
//                
//
//                                    $appointment=$appointment->where('a.memberID='.$vipMemberId);
//
//       
//                        	} 
    if ($service) {
      //  $appointment=$appointment->where('a.serviceID=?',$service) ;
    }
                        
                     $appointment=$appointment->query()
                                    ->fetch(Zend_Db::FETCH_ASSOC);
                            
                        
                    if ($appointment)
                    {
                        
                             if (!array_key_exists($appointment['appointment_id'], $past_appointment_ids)) {
                                
                                $sql = "select memberID, firstName from members
                         where memberID=" . $appointment['memberID'];

                        $member = $db->query($sql)->fetch(Zend_Db::FETCH_ASSOC);

                        $reserved_tech_member[$TechnicianId]['member'] = $member;
                        
                        $tech_requested=$Technician->select()->where('technicianID=?', $TechnicianId)->query()->fetch(Zend_Db::FETCH_ASSOC);
                        
                       $past_appointment_ids[$appointment['appointment_id']]=  $reserved_tech_member[$TechnicianId]['appointment_id'] = $appointment['appointment_id'];

                         
                        $reserved_tech_member[$Technician_row['technicianID']]['tech_requested'] = $tech_requested;

                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['data'] = $reserved_tech_member;
                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['time_id'] = $Time_id;

                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['status'] = "booked";
                        
                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['appointment'] = $appointment;
                        // technitian status
                        unset($reserved_tech_member);
                             }                  

    
    
    
                    } else {
                               $techhouravailble=$Technicianhours->select()
                                         ->where('day=?',$day)
                                         ->where('closeAllDay=1')
                                         ->where('open<=?',$interval_time)
                                         ->Where('close>=?',$interval_time)
                                         ->where('technicianID=?',$TechnicianId)
                                         ->query()
                                         ->fetch(Zend_Db::FETCH_OBJ)
                                         
                                         ;
                               
       
       
    if ($techhouravailble) {

                    
                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]= array('status'=>"available",'time_id'=>$Time_id);
                        
	} else {

                    
                        $TechniciansAvailable[$TechnicianId] [$time_obj->interval_time]= array('status'=>"no_service",'time_id'=>$Time_id);
                        
}

                    }
                    
                    

       

	} else {
       
       $techserviceavailble=null;
       
                                 $techserviceavailble= $Technicianservices->select()->where('technicianID='.$TechnicianId);
                               
                              
                                     $techserviceavailble= $techserviceavailble->query()
                                            ->fetchAll(Zend_Db::FETCH_OBJ);
                                     
                      
                      
                if ( $techserviceavailble ) {
                  
                     $day=date('l',strtotime($date));
       

                    $db= $appointments->getDefaultAdapter();
                    $appointment=$db->select()
                                    ->from(array('a'=>'appointments'))
                                    ->join(array('r'=>'technician_reserved_hours'),'a.id=r.appointment_id')
                                    ->join(array('atchr'=>'alltechnicianhours'),'r.time_id=atchr.id',array('interval_time'))
                                     ->join(array('s'=>'services'),'s.serviceID=a.serviceID',array('*'))
                                    ->where('a.date=?', $date)
                                    ->where('r.technicianID=?',$TechnicianId)
                                    ->where('r.time_id=?',$Time_id) ;
                        

        
                           if ( My_Auth::getInstance()->isVIPMember() ){

                                     $vipMemberId=My_Auth::getInstance()->getLoggedUser('memberID');
                
                

                                    $appointment=$appointment->where('a.memberID='.$vipMemberId);

       
                        	} 
    if ($service) {
      //  $appointment=$appointment->where('a.serviceID=?',$service) ;
    }
                        
                     $appointment=$appointment->query()
                                    ->fetch(Zend_Db::FETCH_ASSOC);
                            
                        
                    if ($appointment)
                    {
                       // die ("k");
                        
                             if (!array_key_exists($appointment['appointment_id'], $past_appointment_ids)) {
                                
                                
                                $sql = "select memberID, firstName from members
                         where memberID=" . $appointment['memberID'];

                        $member = $db->query($sql)->fetch(Zend_Db::FETCH_ASSOC);

                        $reserved_tech_member[$TechnicianId]['member'] = $member;
                        
                        $tech_requested=$Technician->select()->where('technicianID=?', $TechnicianId)->query()->fetch(Zend_Db::FETCH_ASSOC);
                        
                       $past_appointment_ids[$appointment['appointment_id']]=  $reserved_tech_member[$TechnicianId]['appointment_id'] = $appointment['appointment_id'];

                         
                        $reserved_tech_member[$Technician_row['technicianID']]['tech_requested'] = $tech_requested;

                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['data'] = $reserved_tech_member;
                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['time_id'] = $Time_id;

                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['status'] = "booked";
                        
                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['appointment'] = $appointment;
                        
                           
                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]['no_edit'] = 'no_edit';
                       
                        
                        // technitian status
                        unset($reserved_tech_member);
                             }                  

    
    
    
                    } else {
                               $techhouravailble=$Technicianhours->select()
                                         ->where('day=?',$day)
                                         ->where('closeAllDay=1')
                                         ->where('open<=?',$interval_time)
                                         ->Where('close>=?',$interval_time)
                                         ->where('technicianID=?',$TechnicianId)
                                         ->query()
                                         ->fetch(Zend_Db::FETCH_OBJ)
                                         
                                         ;
                               

                        $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]= array('status'=>"available",'time_id'=>$Time_id);
                        
       
                        $TechniciansAvailable[$TechnicianId] [$time_obj->interval_time]= array('status'=>"no_service",'time_id'=>$Time_id);
                        


                    }
                    
                    

	}
       
       
 
       
       
 // $TechniciansAvailable[$TechnicianId ][$time_obj->interval_time]= array('status'=>"no_service",'time_id'=>$Time_id);
                       
       
}
  
            }

            }


        }
        
//	    echo '<pre>';
//        print_r(   $TechniciansAvailable  );
//
//        echo '</pre>'; 
//        
//        die('DEBUGh');

 $this->view->TechniciansAvailable = $TechniciansAvailable;

}

public function recentmembersAction(){


       $appointments = new Application_Model_Appointments();
       $allAppointments=$appointments->select()
                                      
                                        ->order(array('date DESC'))->query()->fetchAll(Zend_Db::FETCH_OBJ);
       
       
       
       $this->view->allAppointments=$allAppointments;
       
       $members = new Application_Model_Members();

}

public function saverecentappointmentsAction(){


       $appointments = new Application_Model_Appointments();
     
        $appointments->update(array('note'=>$_POST['note']),'id='.$_POST['appointmnet_id']);

       $this->_redirect('/appointments/recentappointments');

}

public function recentappointmentsAction(){

   
       $appointments = new Application_Model_Appointments();
        $TechResHours = new Application_Model_TechnicianReservedHours();
         $AllTechnicalHours = new Application_Model_Alltechnicianhours();
           $Technician = new Application_Model_Technician();
     $finalAppointments=array();
        $db=$appointments->getDefaultAdapter();
       $appointment=$db->select()
                                    ->from(array('a'=>'appointments'))
                                   // ->join(array('r'=>'technician_reserved_hours'),'a.id=r.appointment_id')
                                 //  ->join(array('atchr'=>'alltechnicianhours'),'r.time_id=atchr.id',array('interval_time'))
                               
                                   ->join(array('s'=>'services'),'s.serviceID=a.serviceID',array('*'))
                                   ->join(array('m'=>'members'),'m.memberID=a.memberID',array('*'))
                                    ->order('a.date desc')
                                       ->where('a.recent_closed=0')
                                    ->query()
                                    ->fetchAll(Zend_Db::FETCH_ASSOC)
                                   
                                    
                                    ;
                        
                 $rows=$appointment;
         if (is_array($rows)) {
            
	       foreach ($rows as $row) {
	           
               
               
               $data=$db->select()->from(array('trh'=>'technician_reserved_hours'))
                                    ->where('appointment_id='.$row['id'])
                                    ->query()
                                    ->fetchAll(Zend_Db::FETCH_ASSOC)
                                    ;
                         
               $time_id=$data[0]['time_id'];
               
               $technicianID=$data[0]['technicianID'];
               
               $technicianarr=$Technician->select()->where('technicianID='.$technicianID)->query()->fetch(Zend_Db::FETCH_ASSOC);              
               $interval_time=$db->select()->from(array('th'=>'alltechnicianhours'))
                                    ->where('id='.$time_id)
                                    ->query()
                                    ->fetch(Zend_Db::FETCH_OBJ)->interval_time
                                    ;
               $row['interval_time']=$interval_time;
               $row['technician_name']=$technicianarr['Name'];
               $finalAppointments[]=$row;
	
           }
         }
               
//	    echo '<pre>';
//        print_r(   $finalAppointments);
//        echodg '</pre>';
//        
//        die('DEBUG');
               
                  $paginator = Zend_Paginator::factory($finalAppointments);   
                  $paginator->setCurrentPageNumber($this->_getParam('page',1));  
                  $paginator->setDefaultItemCountPerPage(20);
                  $this->view->paginator = $paginator;
       
   

}



public function saveAppointmentAction(){

       $id=$_POST['current_appointment_id'];
         
//  date=2012-10-15&firstName=Pascal&memberID=Pascal+Ledesma&lastName=Ledesma&phCode=(954&phone=5566&serviceID=2&current_appointment_id=8&new_time_id=46&new_technicianID=4    
         
//	    echo '<pre>';
//        print_r( $_POST    );
//        echo '</pre>';
//        
//        die('DEBUG');
       $appointments = new Application_Model_Appointments();
       
       $services = new Application_Model_Services();
        $TechResHours = new Application_Model_TechnicianReservedHours();
                 
       $oldTechHours=$TechResHours->fetchAll('appointment_id='.$id)->toArray();
       
        
        $oldappointment=  self::getAppointment($id);
       
       $where="id=".$id;
       
       $data['date']=$this->USAToMySQLDate(trim($_POST['date']));
       $new_time_id=trim($_POST['new_time_id']);
       
       $new_serviceID=trim($_POST['serviceID']);
       
       $new_technicianID= $_POST['new_technicianID'];
       
       
       $oldserviceID=$oldappointment->serviceID;
       
       
       $db=Zend_Db_Table::getDefaultAdapter();
       
      

       if ( $oldserviceID!=$new_serviceID ){
        
        $data['serviceID']=$new_serviceID;
        
       $data1['appointment_id']=$id;
        
         $TechResHours->delete( "appointment_id=".$id);
         
         $no_service_timeids=$services->select()->where('serviceId='.$new_serviceID)->query()->fetch(Zend_Db::FETCH_OBJ)->duration/15;
        
        for ($i=0;$i<$no_service_timeids;$i++) {
            
            
        	$data1['time_id'] = $new_time_id+$i;
    
            $data1['technicianID'] =$new_technicianID ;
            
            $TechResHours->insert($data1);
            
            
}
         
         
        
        
       } else {
        
        
                 $rows=$oldTechHours;
         if (is_array($rows)) {
            
	       foreach ($rows as $row) {
	           $data2=array('time_id'=>$new_time_id,'technicianID'=>$new_technicianID);
               
               $TechResHours->update(  $data2,'id='.$row['id'] );
               $new_time_id++;
	
           }
         }
       }
       

       // checking if the time slots or tcehnicin left
       
       $appointments->update($data, $where);
       
       $AllTechnicalHours = new Application_Model_Alltechnicianhours();
               
     //  $new_time_id=$AllTechnicalHours->select()->where('interval_time=?',$time)->query()->fetch(Zend_Db::FETCH_OBJ)->id;
               
      
        
      //  die('DEBUG');
       
       
       
       
      $this->_redirect('appointments');
}


public function isUpdatePossibleAction(){
	
     
       
        $appointments = new Application_Model_Appointments();
        $TechResHours = new Application_Model_TechnicianReservedHours();
        
        extract($_POST);
       
}


    public function makeappointmentAction()
    {
        $post = $_POST;
        
        $members = new Application_Model_Members();
               
       //
//	    echo '<pre>';
//        print_r(   $_POST  );
//        echo '</pre>';
//        
//        die('DEBUG');
//      
        foreach ($post as $row => $value)
        {
            if (stristr($row, 'technitian_'))
            {
                list($name, $id,$technitian_id) = explode('_', $row);
                $technitian_timeids[] = $id;
              //  $technitian_ids[$row] = $value;
                unset($_POST['technitian_' . $id]);
                // echo  substr( $row, -1,strlen( $row )-11 );
                //  echo $value;
            }


        }
        
       // $technitian_ids=array_unique($technitian_ids);
       $technitian_timeids= array_unique($technitian_timeids) ;
       
       
       
                $rows=$technitian_timeids;
         if (is_array($rows)) {
            
	       foreach ($rows as $row) {
	
                foreach ( $_POST as $key=>$value   ){
                      if (stristr($key, $row))
            {
                
                $timeIDSTechnicians[$row][]=$value;
          
            }

                     
                }
                
           }
         }
       
       
     //   
//                      
//	    echo '<pre>';
//        print_r( $timeIDSTechnicians );
//        echo '</pre>';
//        
//        die('DEBUG');
//       
//       
       
      if (!$technitian_timeids) {
        return;
      }

   $services = new Application_Model_Services();
   
           
	    
        if (!$_POST['memberID'] && My_Auth::getInstance()->isAdmin() )
        {


            $members = new Application_Model_Members();


            $data2['firstName'] = trim($_POST['firstName']);

            $data2['lastName'] = trim($_POST['lastName']);
            $data2['phCode'] = trim($_POST['phCode']);


            $data2['phone'] = trim($_POST['phone']);
            $data2['email'] = '';
            $data2['password'] = '';
            $data2['vipMember']=2;
            $data2['date_created']= $now = date('Y-m-d H:i:s', time());

            $_POST['memberID'] = $members->insert($data2);
        } else {
            
            $_POST['memberID']=$members->select('*')
                        ->where('firstName LIKE ?' , $_POST['firstName'])
                       
                        
                                ->query()->fetch(Zend_DB::FETCH_OBJ)->memberID;
                                
           
        }


  
               
//	    echo '<pre>';
//        print_r(   $_POST  );
//        echo '</pre>';
//     
//        
//       
//           
//        die('DEBUG');
//        
        
        
        
        
        
        // $data['technicianID']=$_POST[''];
        $data['memberID'] =$_POST['memberID'] ;
        $serviceId = $data['serviceID'] = $_POST['serviceID'];
        
        $data['date'] =self::USAToMySQLDate($_POST['date']);
        
        $data['tech_requested']=$_POST['tech_requested'];

        $appointments = new Application_Model_Appointments();

   
        //     	technician_reserved_hours 	time_id 	appointment_id
        
     //   
//     //   
   	  //  echo '<pre>';
//        print_r( $data  );
//        echo '</pre>';
//     
//         echo '<pre>';
//        print_r( $technitian_timeids   );
//        echo '</pre>';
//        
//        
//        die('DEBUG');
        
   
        foreach ($timeIDSTechnicians as $time_id=>$technitian_ids )
        {


            $TechResHours = new Application_Model_TechnicianReservedHours();

           
            
            // Depending on the 

        $service_duration=$services->select()
                                    ->where('serviceID=?',$serviceId)
                                    ->query()
                                    ->fetch(Zend_Db::FETCH_OBJ)
                                    ->duration;
                                    
                                
        $no_service_timeids=$service_duration/15;
         
         
         
         
         
         foreach ( $technitian_ids as $row ) {
	

    //    $data['technicianID']=$row;
         
        $appointment_id = $appointments->insert($data);

         
            $data1['appointment_id'] = $appointment_id;
            
            
         for ($i=0;$i<$no_service_timeids;$i++) {
            
            
        	$data1['time_id'] = $time_id+$i;
    
          $data1['technicianID'] = $row;
            
            $TechResHours->insert($data1);
            
            
}
         
  }       
                   


        }


        echo $this->_helper->json(array('status' => true));
        //  $this->_redirect('appointments');
        die("h");

    }

 public function autocompletecustomerAction()
    {


            $members = new Application_Model_Members();
            $db=$members->getDefaultAdapter();
            
            $members=array('m'=>"members");
            
          

$term1=$term = trim(strip_tags($this->_getParam('term')));

    $result=$db->query("select CONCAT(firstName, ' ', lastName)
            
            As name, memberID from members where firstName LIKE '$term%' ")->fetchAll();
            
            
            
        $result1=$db->query("select  CONCAT(firstName, ' ', lastName)
            
            As name, memberID from members where   lastName LIKE '$term1%'")->fetchAll();
            
                   
	  //  echo '<pre>';
//        print_r(   $result  );
//        echo '</pre>';
//         echo '<pre>';
//        print_r(   $result1  );
//        echo '</pre>';
//        
//        die('DEBUG');
                  
                     $rows=$result;
                     
                     $rows1=$result1;
                     
         if (is_array($rows)) {
            
         
	       foreach ($rows as $row) {
	               $values1[$row['memberID']]=$row['name'];
           }
           
         }
         
                  if (is_array($rows1)) {
            
         
	       foreach ($rows1 as $row) {
	               $values1[$row['memberID']]=$row['name'];
           }
           
         }
         
         
//          
 foreach ($values1 as $row) {
	               $values[]=$row;
           }





  
            echo $this->_helper->json($values);


    }
    
    public function loadcustomerAction()
    {

        $id = $this->_getParam('id');
        
        list($fname, $lname)=explode(' ', $id);
        if ($id)
        {


            $db=Zend_Db_Table_Abstract::getDefaultAdapter();
            
            $members = new Application_Model_Members();
            $member1 = $db->select('memberID')->from('members')->where('firstName LIKE ?' , "$fname")
                                ->query()->fetchAll();
             $member2 = $db->select('memberID')->from('members')->where('lastName LIKE ?' , "$lname")
                                ->query()->fetchAll();
              
                 $rows=$member1;
         if (is_array($rows)) {
            
	       foreach ($rows as $row) {
	               $memberIDS1[]=$row['memberID'];
           }
         }
                    $rows=$member2;
         if (is_array($rows)) {
            
	       foreach ($rows as $row) {
	               $memberIDS2[]=$row['memberID'];
           }
         }   
         
          
            $result=array_intersect($memberIDS1,$memberIDS2);
            
            $memberID=array_shift($result);
            
            
                                 
	       $member=$members->fetchRow('memberID='.$memberID)->toArray();  
            
    
            echo $this->_helper->json($member);

        }


    }
    


    public function loadappointmentAction()
    {

        $this->_helper->layout->disableLayout();
        
        $id = $this->_getParam('id');
        if ($id)
        {

            $appointments = new Application_Model_Appointments();

            $TechResHours = new Application_Model_TechnicianReservedHours();

            $Technician = new Application_Model_Technician();
            $services = new Application_Model_Services();
            $members = new Application_Model_Members();
            //     	technician_reserved_hours 	time_id 	appointment_id

            $db=$appointments->getAdapter();
            $appointment = $db->select()
                        //  ->setIntegrityCheck(false)
                    ->from(array('a'=>'appointments'),array('a.id AS appointment_id','date'))
                    ->join(array('m'=>'members'),'m.memberID=a.memberID','*')
                    ->join(array('s'=>'services'),'s.serviceID=a.serviceID','*')
                    ->join(array('trh'=>'technician_reserved_hours'),
                    'trh.appointment_id=a.id',array('technicianID','time_id'))
                    ->join(array('th'=>'alltechnicianhours'),'th.id=trh.time_id')
                     ->join(array('t'=>'technician'),'t.technicianID=trh.technicianID')
                    ->where('a.id='.$id)
                 
                    ->query()
                    ->fetch(Zend_Db::FETCH_OBJ);
            $this->view->appointment=$appointment;
                    
          //  $member=$members->find($appointment->memberID)->current();
          
          //   technicianID 	time_id 	appointment_id Ascending
     //  
//	    echo '<pre>';
//        print_r(  $appointment    );
//        echo '</pre>';
//        
//        die('DEBUG');
//


 ?> 
 

     <?php




         //   echo $this->_helper->json( $appointment );
         
       

        }
    }

//    public function loadtechnitiantableAction()
//    {
//        /*
//         
//        find openinng and closing status from the custom shop hours. if these is no opening 
//        and closing time for that date in custom table, normal shop hours opening and closing time
//        will be used. Those opeinng and closing time will be used 
//        for technitian working time.
//        find technitians with required service with their available, booked, no service status for a specified day.
//        
//        
//        
//        */
//        
//      //  die ("F");
//        
//        
//        $this->_helper->layout->disableLayout();
//        $date = date('Y-m-d',strtotime($this->_getParam('date')));
//        echo $this->_getParam('date')."<br/>";
//  //      	echo $date;
////    die ('DEBUG');
//        $service=$this->_getParam('serviceID');
//        $Technician = new Application_Model_Technician();
//        $services = new Application_Model_Services();
//        $members = new Application_Model_Members();
//        $form = new Application_Form_Memberappointment();
//        $appointments = new Application_Model_Appointments();
//        $TechResHours = new Application_Model_TechnicianReservedHours();
//        $AllTechnicalHours = new Application_Model_Alltechnicianhours();
//        
//        $Technicianhours = new Application_Model_Technicianhours();
//                    
//                      
//        $Technicianservices = new Application_Model_Technicianservices();
//                   
//
//        
//        $ShopHours = new Application_Model_Shophours();
//
//        $ShopCustomHours = new Application_Model_Shopcustomhours();
//
//        $membersArr = $this->view->members = $members->fetchAll()->toArray();
//
//
//        
//
//        $servicesArr = $this->view->services = $services->fetchAll()->toArray();
//
//
//        $AllTechnicalHoursValues = $AllTechnicalHours->fetchAll()->toArray();
//
//
//        foreach ($AllTechnicalHoursValues as $row)
//        {
//            $AllTechnicalHoursArr[$row['id']] = $row['interval'];
//        }
//
//        //print_r($AllTechnicalHoursArr );
//
//        $this->view->AllTechnicalHours = $AllTechnicalHoursArr;
//        
//
//
//// some chnages when user is vip member
//
//
//
//        $appointmentsArr = $appointments
//
//                                                    ->fetchAll()
//                                                    ->toArray();
//        
//        $this->view->TechResHours = $TechResHours->fetchAll()->toArray();
// 
//
//        if (!$date || !$service)
//        {
//            return;
//        }
//
//// die('DEBUG');
//// checking shop custom hours for date
////          ID 	day 	date 	closeAllDay 	start 	end 	comments 
//
//        $dayshopHours = $ShopCustomHours->select()->where("date=?", $date)->query()->
//            fetch(Zend_Db::FETCH_OBJ);
//            
//
//if ( $dayshopHours ) {
//    
//    
//        if (!$dayshopHours->closeAllDay) {
//            
//            
//        $dayStart = $dayshopHours->start;
//
//        $dayEnd = $dayshopHours->end;
//        } else {
//            die ("closed");
//        }
//        
//
//	} else {
//
//// find dAy for the date
//
//
//$day=date('l', strtotime($date) );
//
//$shophour=$ShopHours->select()
//                ->where('day=?',$day)
//                ->where('closeAllday=1')
//                ->query()
//                ->fetch(Zend_Db::FETCH_OBJ);
//if ($shophour) {
//    
//       
//	  $dayStart=$shophour->open;
//      $dayEnd=$shophour->close;
//}else {
//    echo "Day's operation is closed";
//    
//    die ('');
//}
//      
//     // echo $dayStart." ".$dayEnd." ".$day;
//     // die ("f");
//
//}
//
//
//
//        $starttimeId = $AllTechnicalHours->select()->where("interval_time=?", $dayStart)->
//            query()->fetch(Zend_Db::FETCH_OBJ)->id;
//    
//
//        $endtimeId = $AllTechnicalHours->select()->where("interval_time=?", $dayEnd)
//        ->query()->fetch(Zend_Db::FETCH_OBJ)->id;
//
//        $AllTechnicalHoursfordate = $AllTechnicalHours->select()->limit($endtimeId - $starttimeId +
//            1, $starttimeId - 1)->query()->fetchAll(Zend_Db::FETCH_OBJ);
//
//
//        $db = $ShopCustomHours->getAdapter();
//        
//         $this->view->Technician = $Technician->fetchAll()->toArray();
//
//
//        $TechniciansAvailable = array();
//        $TechniciansArr=$Technician->select(Zend_Db_Table::SELECT_WITH_FROM_PART)->setIntegrityCheck(false)
//                                   // ->join('technicianservices','technicianservices.technicianID=technician.technicianID',array(''))
//                                   // ->where('technicianservices.serviceID='.$service)
//                                    ->query()
//                                    ->fetchAll(Zend_Db::FETCH_ASSOC);
//        foreach ($AllTechnicalHoursfordate as $time_obj)
//        {
//
//            $Time_id = $time_obj->id;
//            $interval_time=$this->timeConversion12hTO24h($time_obj->interval_time).":00";
//            $reserved_tech_member = array();
//
//            foreach ($TechniciansArr as $Technician_row)
//            {
//
//                $TechnicianId = $Technician_row['technicianID'];
//                
//         
//              
//
//
//                reserv
//           // if (!array_key_exists($time_obj->interval_time, $TechniciansAvailable))
////            {
////                $TechniciansAvailable[$time_obj->interval_time]['data'] = null;
////                $TechniciansAvailable[$time_obj->interval_time]['time_id'] = $Time_id;
////            
////            }
//            if ( !$TechniciansAvailable[$time_obj->interval_time][$TechnicianId ]['status']  ){
//                               $techserviceavailble= $Technicianservices->select()->where('technicianID='.$TechnicianId);
//                                      
//                                      
//                     if ($service){
//                         $techserviceavailble= $techserviceavailble->where('serviceID='.$service);
//                     }                     
//                                      
//               
//               
//                    $techserviceavailble= $techserviceavailble->query()->fetchAll(Zend_Db::FETCH_OBJ);
//       //        
////                      
////	    echo '<pre>';
////        print_r(  $techserviceavailble   );
////        echo '</pre>';
////        
////        die('DEBUG');                           
//                if ( $techserviceavailble ) {
//                    $day=date('l',strtotime($date));
//       
//    //   echo $day." ".$interval_time;
//   
// //  echo $TechnicianId." ";
//
////die('DEBUG');
//                    $db= $appointments->getDefaultAdapter();
//                    $appointment=$db->select()
//                                    ->from(array('a'=>'appointments'))
//                                    ->join(array('r'=>'technician_reserved_hours'),'a.id=r.appointment_id')
//                                    ->join(array('atchr'=>'alltechnicianhours'),'r.time_id=atchr.id',array('interval_time'))
//                                     ->join(array('s'=>'services'),'s.serviceID=a.serviceID',array('*'))
//                              
//                              
//                                    ->where('a.date=?', $date)
//                                    ->where('r.technicianID=?',$TechnicianId)
//                                    ->where('r.time_id=?',$Time_id) ;
//                        
//        
//                           if ( My_Auth::getInstance()->isVIPMember() ){
//
//            
//           
//
//                $vipMemberId=My_Auth::getInstance()->getLoggedUser('memberID');
//                $appointment=$appointment->where('a.appointment_id='.$vipMemberId);
//
//       
//	} 
//                        
//                     $appointment=$appointment->query()
//                                    ->fetch(Zend_Db::FETCH_ASSOC);
//                            
//                        
//                    if ($appointment)
//                    {
//                        
//                                               
//	  //  echo  $appointment ;
//        //die('DEBUG');
//          
//                        $sql = "select memberID, firstName from members
//                         where memberID=" . $appointment['memberID'];
//
//                        $member = $db->query($sql)->fetch(Zend_Db::FETCH_ASSOC);
//
//                        $reserved_tech_member[$Technician_row['technicianID']]['member'] = $member;
//                        
//                        $reserved_tech_member[$Technician_row['technicianID']]['appointment_id'] = $appointment['appointment_id'];
//
//                         
//                        $reserved_tech_member[$Technician_row['technicianID']]['tech_requested'] = $appointment['tech_requested'];
//
//                        $TechniciansAvailable[$time_obj->interval_time][$TechnicianId ]['data'] = $reserved_tech_member;
//                        $TechniciansAvailable[$time_obj->interval_time][$TechnicianId ]['time_id'] = $Time_id;
//
//                        $TechniciansAvailable[$time_obj->interval_time][$TechnicianId ]['status'] = "booked";
//                        
//                        $TechniciansAvailable[$time_obj->interval_time][$TechnicianId ]['appointment'] = $appointment;
//                        // technitian status
//                        
//                      
//                    } else {
//                               $techhouravailble=$Technicianhours->select()
//                                         ->where('day=?',$day)
//                                         ->where('closeAllDay=1')
//                                         ->where('open<=?',$interval_time)
//                                         ->Where('close>=?',$interval_time)
//                                         ->where('technicianID=?',$TechnicianId)
//                                         ->query()
//                                         ->fetch(Zend_Db::FETCH_OBJ)
//                                         
//                                         ;
//      
//       
//       
//    if ($techhouravailble) {
//
//                    
//                        $TechniciansAvailable[$time_obj->interval_time][$TechnicianId ]= array('status'=>"available",'time_id'=>$Time_id);
//                        
//	} else {
//
//                    
//                        $TechniciansAvailable[$time_obj->interval_time][$TechnicianId ]['status'] = "no_service";
//                        
//}
//
//                    }
//
//       
//
//	} else {
//	   
//      $TechniciansAvailable[$time_obj->interval_time][$TechnicianId ]['status'] = "no_service";
//                       
//       
//}  
//  
//            }
//
//            }

//
//        }
////        
////
//    //   
////	    echo '<pre>';
////        print_r(   $TechniciansAvailable  );
////        echo '</pre>';
////        
////        die('DEBUG');
////
////
///
// $this->view->TechniciansAvailable = $TechniciansAvailable;
//
//
//    }
      
public function deleteRecentAppointmentAction (){
	
    
    
    $id=$this->_getParam('id');
    
            $appointments = new Application_Model_Appointments();

            $TechResHours = new Application_Model_TechnicianReservedHours();


$db=$appointments->getAdapter();


$db->beginTransaction();


$data['recent_closed']=1;
$appointments->update( $data, 'id='.$id );



$db->commit();




    $this->_redirect('appointments/recentappointments');


die ("");
    
    
}
  
    
public function deleteAppointmentAction (){
	
    
    
    $id=$this->_getParam('id');
    
            $appointments = new Application_Model_Appointments();

            $TechResHours = new Application_Model_TechnicianReservedHours();


$db=$appointments->getAdapter();


$db->beginTransaction();



$appointments->delete( 'id='.$id );

$TechResHours->delete( 'appointment_id='.$id );



$db->commit();



$this->_redirect( 'appointments/index' );
    
}

  


    public function indexAction()
    {


        $this->view->headTitle(" Appointment Management");
        $Technician = new Application_Model_Technician();
        $services = new Application_Model_Services();
        $members = new Application_Model_Members();
        $form = new Application_Form_Memberappointment();
        $appointments = new Application_Model_Appointments();
        $TechResHours = new Application_Model_TechnicianReservedHours();
        $AllTechnicalHours = new Application_Model_Alltechnicianhours();

        $ShopCustomHours = new Application_Model_Shopcustomhours();

        $membersArr = $this->view->members = $members->fetchAll()->toArray();


        $TechniciansArr = $this->view->Technician = $Technician->fetchAll()->toArray();

        $servicesArr = $this->view->services = $services->fetchAll()->toArray();


        $AllTechnicalHoursValues = $AllTechnicalHours->fetchAll()->toArray();


        foreach ($AllTechnicalHoursValues as $row)
        {
            $AllTechnicalHoursArr[$row['id']] = $row['interval'];
        }

        //print_r($AllTechnicalHoursArr );

        $this->view->AllTechnicalHours = $AllTechnicalHoursArr;

        //  die ("f");
        $rows = $membersArr;
        if (is_array($rows))
        {

            $membersOptions[0] = 'Please Select';
            foreach ($rows as $row)
            {
                $membersOptions[$row['memberID']] = $row['firstName'];
            }
        }

        $rows = $servicesArr;
        if (is_array($rows))
        {
          $servicesOptions[null]="Select Service";
            
            foreach ($rows as $row)
            {
                $servicesOptions[$row['serviceID']] = $row['serviceName']." : ".$row['duration']." Min";
             $servicesIdsDurations[$row['serviceID']]=$row['duration']; }
        }
       
        $this->view->servicesIdsDurations=$servicesIdsDurations;
        
        
  //      	    echo '<pre>';
//        print_r(   $this->view->servicesIdsDurations  );
//        echo '</pre>';
//        
//        die('DEBUG');
//        

     //   $form->memberID->setMultiOptions($membersOptions);

        $form->serviceID->setMultiOptions($servicesOptions);

if ( My_Auth::getInstance()->isVIPMember() ){

            
           $vipMemberId=My_Auth::getInstance()->getLoggedUser('memberID');
            $f_name=My_Auth::getInstance()->getLoggedUser('firstName');
            $l_name=My_Auth::getInstance()->getLoggedUser('lastName');
            $name=$f_name." ".$l_name;
            $form->memberID->setValue( $name  );
             $form->firstName->setValue( $f_name  );
              $form->lastName->setValue( $l_name  );
            $form->memberID->setAttrib('disabled','disabled'); 
            

       
	} 

      //  $form->serviceID->setValue(2);

        $this->view->appointments = $appointments->fetchAll()->toArray();
        $this->view->TechResHours = $TechResHours->fetchAll()->toArray();
        $this->view->form = $form;


        $date = $this->_getParam('date');


        if (!$date)
        {
            return;
        }


        $dayshopHours = $ShopCustomHours->select()->where("date=?", $date)->query()->
            fetch(Zend_Db::FETCH_OBJ);

        $dayStart = $dayshopHours->start;

        $dayEnd = $dayshopHours->end;

        $starttimeId = $AllTechnicalHours->select()->where("interval_time=?", $dayStart)->
            query()->fetch(Zend_Db::FETCH_OBJ)->id;


        $endtimeId = $AllTechnicalHours->select()->where("interval_time=?", $dayEnd)->
            query()->fetch(Zend_Db::FETCH_OBJ)->id;

        $AllTechnicalHoursfordate = $AllTechnicalHours->select()->limit($endtimeId - $starttimeId +
            1, $starttimeId - 1)->query()->fetchAll(Zend_Db::FETCH_OBJ);


        $db = $ShopCustomHours->getAdapter();


        $TechniciansAvailable = array();


        foreach ($AllTechnicalHoursfordate as $time_obj)
        {

            $Time_id = $time_obj->id;
            $reserved_tech_member = array();

            foreach ($TechniciansArr as $Technician_row)
            {

                $TechnicianId = $Technician_row['technicianID'];

                $reserve = $TechResHours->select()->where('technicianID=' . $TechnicianId)->
                    where('time_id=?', $Time_id)->query()->fetch(Zend_Db::FETCH_ASSOC);

                //  echo $TechnicianId." ".$Time_id."<br/>";

                if ($reserve)
                {
                    $appointment = $appointments->select()->where('id=' . $reserve['appointment_id'])->
                        where('date=?', $date)->query()->fetch(Zend_Db::FETCH_ASSOC);
                    if ($appointment)
                    {

                        $sql = "select memberID, firstName from members
                         where memberID=" . $appointment['memberID'];

                        $member = $db->query($sql)->fetch(Zend_Db::FETCH_ASSOC);

                        $reserved_tech_member[$Technician_row['technicianID']]['member'] = $member;

                        $TechniciansAvailable[$time_obj->interval_time]['data'] = $reserved_tech_member;
                        $TechniciansAvailable[$time_obj->interval_time]['time_id'] = $Time_id;
                    }
                    
                   
                }
                
                
            }
            if (!array_key_exists($time_obj->interval_time, $TechniciansAvailable))
            {
                $TechniciansAvailable[$time_obj->interval_time]['data'] = null;
                $TechniciansAvailable[$time_obj->interval_time]['time_id'] = $Time_id;
            }

        }


        $this->view->TechniciansAvailable = $TechniciansAvailable;

    }
     public function timeConversion24hTO12h($time_24h)
    {
        // 24-hour time to 12-hour time
        return $time_in_12_hour_format = date("g:i a", strtotime($time_24h));

    }
    public function timeConversion12hTO24h($time_12h)
    {
        // 12-hour time to 24-hour time
      return  $time_in_24_hour_format = date("H:i", strtotime($time_12h));

    }
      
   public function timeToTimeID( $time ){
	
  //  echo $time;
         $AllTechnicalHours = new Application_Model_Alltechnicianhours();
        return $timeObj=$AllTechnicalHours->select()
                                    ->where('interval_time=?',$time)
                                    ->query()
                                    ->fetch(Zend_Db::FETCH_OBJ)
                                    ->id;
                                    
                                          
      
    
    }
    
   public function timeIdToTime( $time_id ){
	
    
         $AllTechnicalHours = new Application_Model_Alltechnicianhours();
        return $timeObj=$AllTechnicalHours->select()
                                    ->where('id=?',$time_id)
                                    ->query()
                                    ->fetch(Zend_Db::FETCH_OBJ)
                                    ->interval_time;
            
    
    }
}
