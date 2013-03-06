<?php

/**
 * @author lolkittens
 * @copyright 2012
 */


class My_Form_Helper
{

    public static $db = null;
    protected static $_instance = null;

    public static function getInstance()
    {

        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        self::$db = Zend_Db_Table_Abstract::getDefaultAdapter();


        return self::$_instance;

    }
    public function __construct()
    {
        $this->auth = Zend_Db_Table_Abstract::getDefaultAdapter();
    }


public function getEventById($id){
    
        $db=Zend_Db_Table_Abstract::getDefaultAdapter();
    
        
        $event = $this->view->results = $db->select()
                                        ->from(array('c'=>'sits_calendar'),array('c.id as calender_id','*'))
                                        ->join(array('co'=>'sits_course'),'co.id=c.course_id',array('co.id AS course_id','*'))
                                        ->where('c.id=?',$id)
                                        ->query()->fetch(Zend_Db::FETCH_OBJ);
                                        
         return $event;                               
	
}

    public function getRow($table, $where = null)
    {

        $db = self::$db;

        $optionsObjs = $db->select()->from($table, '*');

        if ($where) {


            if (is_array($where))
                foreach ($where as $k => $v) {

                    $optionsObjs = $optionsObjs->where($k . '=' . $v);

                }
            else
                $optionsObjs = $optionsObjs->where($where);


        } else {
            return false;
        }

        return $optionsObjs->query()->fetch(Zend_Db::FETCH_OBJ);


    }


    public function getSelectOptionsFromDb($table, $key, $value, $where = null)
    {

        $db = self::$db;

        $optionsObjs = $db->select()->from($table, array($key, $value));

        if ($where) {

            $optionsObjs = $optionsObjs->where($where);
        }

        $optionsObjs = $optionsObjs->query()->fetchAll(Zend_Db::FETCH_OBJ);

        $rows = $optionsObjs;
        $options[0] = "Select One";
        if (is_array($rows)) {

            foreach ($rows as $row) {
                $options[$row->$key] = $row->$value;
            }
        }

        return $options;

    }
    
    
        
    
    
    public function decodeLinks( $content ){
        
         $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini',

            'production');
       $base_url= $config->base_url;
       $base_url_local=$config->base_url_local;

        $links=array($base_url=>$base_url, $base_url_local=>$base_url_local);
                    if ( isLocalHost() ) {
                 $content= str_replace( 'BASE_URL',$base_url_local ,$content );
       
            } else {
                 $content= str_replace( 'BASE_URL',$base_url ,$content );
       
            }
              
            
     //   echo $content;
        
       preg_match_all( '/gallery_id:[\d]+/',$content,$matches );
	     
                   $rows=$matches ;
                   
  
         if (is_array($rows)) {
            
	       foreach ($rows as $row) {
	           
		       foreach ($row as $row1) {
		          
                  
 
                    if ($row1) {
                        
                        list( $type, $id )=explode(':',$row1);
                                                
	  
                        $text=substr($row1,2,strlen($row1)-4);
                        
                      $url=BASE_URL.'admin/site/widgets/user-top-menu';
                      
                    try{
                        $url_content=file_get_contents($url);
                      
                       echo $url_content;
                
            //    die ("j");
                
                
                        
                    }
                    catch (Exception $e) {
                        
                    }
                    }
           }
                
           }
         }   
        
          return $content;
        
     }   
    
    
    public function encodeLinks( $content ){
        
        
             $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini',

            'production');
       $base_url= $config->base_url;
       $base_url_local=$config->base_url_local;

        $links=array($base_url=>$base_url, $base_url_local=>$base_url_local);
        
          
    $content= str_replace( $base_url, 'BASE_URL',$content );
       
             $content= str_replace( $base_url_local, 'BASE_URL',$content );
     
            
       
        
             if ( isLocalHost() ) {
               
               
               $final_base_url=$base_url_local;
       
            } else {
                     
               $final_base_url=$base_url;
            }
        
      
//	    echo '<pre>';
//        print_r( $marches);
//        echo '</pre>';
//        
//        die('DEBUG');
//        
     
     return $content;
        
	
}


}

?>