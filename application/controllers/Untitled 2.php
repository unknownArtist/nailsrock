<?php

/**
 * @author lolkittens
 * @copyright 2012
 */
             $no_of_times=40;
              $current_time_id= 15;  
              $start_time_id=20; 
              
              
              
              while ( 1 ){
                
                 if ( $start_time_id>$current_time_id ){
                    
                    $end_time_id=$start_time_id-11;
                    break;
                    }
                    $start_time_id=$start_time_id+11;
               
              }
               
               echo $end_time_id;


?>