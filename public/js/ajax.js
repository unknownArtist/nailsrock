//alert("ajax");
$(function (){
    
              
       	jQuery( '#submit' ).click(function (){
    	   
           
         
           
      
           var no_checkboxes=jQuery("input:checkbox:checked").length;
           
           alert(no_checkboxes);
           
            return false;
           
           
           if ( !no_checkboxes ) {
             alert("Select Time");
             
             return false;
           }
           
           
           

          jQuery.ajax({
  url: '/appointments/makeappointment',
  data:jQuery('#appointment-form').serialize(), 
    type: "POST",
  success: function(data) {
    jQuery('.result').html(data);
   alert(data);
 loadAppointments();
   if ( data.status==1 ) {
    alert("Success");
   
   jQuery('#message h1').text("Appointment Created successfully");
   $("#message h1").show().delay(5000).fadeOut();
   $("#message h1").fadeIn('slow').animate({opacity: 1.0}, 5000).effect("pulsate", { times: 2 }, 800).fadeOut('slow'); 

   } else {
       alert("failure");
      jQuery('#message h1').text("Appointment Creation failed");
       $("#message h1").show().delay(5000).fadeOut();
   }


    
  }
});

        });     
        
        

});
          