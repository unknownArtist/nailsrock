  $(function(){

    $("body").addClass("claro");

    $('#time2').append("<label>10:00 AM</label>");
    $('#time3').append("<label>10:15 AM</label>");
    $('#time4').append("<label>10:30 AM</label>");
    $('#time5').append("<label>10:45 AM</label>");
    
    $('#time6').append("<label>11:00 AM</label>");
    $('#time7').append("<label>11:15 AM</label>");
    $('#time8').append("<label>11:30 AM</label>");
    $('#time9').append("<label>11:45 AM</label>");
    
    $('#time10').append("<label>12:00 PM</label>");
    $('#time11').append("<label>12:15 PM</label>");
    $('#time12').append("<label>12:30 PM</label>");
    $('#time13').append("<label>12:45 PM</label>");
    
    $('#time14').append("<label>1:00  PM</label>");
    $('#time15').append("<label>1:15  PM</label>");
    $('#time16').append("<label>1:30  PM</label>");
    $('#time17').append("<label>1:45  PM</label>");
    
    // $('#time3').append("<label>2:00  AM</label>");
    // $('#time3').append("<label>2:15  AM</label>");
    // $('#time3').append("<label>2:30 AM</label>");
    // $('#time3').append("<label>2:45 AM</label>");
    
    // $('#time3').append("<label>3:00 AM</label>");
    // $('#time3').append("<label>3:15  AM</label>");
    // $('#time3').append("<label>3:30 AM</label>");
    // $('#time3').append("<label>3:45 AM</label>");
    
    // $('#time3').append("<label>4:00 AM</label>");
    // $('#time3').append("<label>4:15  AM</label>");
    // $('#time3').append("<label>4:30 AM</label>");
    // $('#time3').append("<label>4:45 AM</label>");
   
    // $('#time3').append("<label>5:00  AM</label>");
    // $('#time3').append("<label>5:15  AM</label>");
    // $('#time3').append("<label>5:30 AM</label>");
    // $('#time3').append("<label>5:45 AM</label>");
   
    
    // $('#time3').append("<label>6:00  AM</label>");
    // $('#time3').append("<label>6:15  AM</label>");
    // $('#time3').append("<label>6:30 AM</label>");
    // $('#time3').append("<label>6:45 AM</label>");
   
    
    //  $('#time3').append("<label>7:00  AM</label>");
    // $('#time3').append("<label>7:15  AM</label>");
    // $('#time3').append("<label>7:30 AM</label>");
    // $('#time3').append("<label>7:45 AM</label>");
    
    // $('#time3').append("<label>8:00 AM</label>");
    // $('#time3').append("<label>8:15 AM</label>");
    // $('#time3').append("<label>8:30 AM</label>");
    // $('#time3').append("<label>8:45 AM</label>");
    
    // $('#time3').append("<label>2:45 AM</label>");
    // $('#time3').append("<label>2:00 AM</label>");

  });
// ###################################################################
  $(document).ready(function() {

              ////////////////////////DatePicker for shop custom hours/////////////////////////
                
              $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
         

              //////////////////////////End of DatePicker//////////////////////////////
             $('#monOpen').timepicker({ 'scrollDefaultNow': true });
             $('#monClose').timepicker({ 'scrollDefaultNow': true });
             $('#tueOpen').timepicker({ 'scrollDefaultNow': true });
             $('#tueClose').timepicker({ 'scrollDefaultNow': true });
             $('#wedOpen').timepicker({ 'scrollDefaultNow': true });
             $('#wedClose').timepicker({ 'scrollDefaultNow': true });
             $('#thu').timepicker({ 'scrollDefaultNow': true });
             $('#thusOpen').timepicker({ 'scrollDefaultNow': true });
             $('#thusClose').timepicker({ 'scrollDefaultNow': true });
             $('#friOpen').timepicker({ 'scrollDefaultNow': true });
             $('#friClose').timepicker({ 'scrollDefaultNow': true });
             $('#sunOpen').timepicker({ 'scrollDefaultNow': true });
             $('#satOpen').timepicker({ 'scrollDefaultNow': true });
             $('#satClose').timepicker({ 'scrollDefaultNow': true });
             $('#sunClose').timepicker({ 'scrollDefaultNow': true });
             $('#shopCustomHoursOpen').timepicker({ 'scrollDefaultNow': true });
             $('#shopCustomHoursClose').timepicker({ 'scrollDefaultNow': true });
});

// #########################this code is for custom shop hours#######################
$(function(){

       $('#AddCustomClosedDay').click(function(){
                
                $this = $("#datepicker");
                if($this.val() == "")
                {
                  
                 $this.css({
                  'border-color': 'red',
                  'border-width':'2px',
                 });
                 $this.effect("shake", { times:3 }, 50);
                 
                  return false;
                }
       });

            $('#customhours').ajaxForm(function(){ 

                    

                  $.ajax({
                  url: "",
                  context: document.body,
                  success: function(s,x){
                    $(this).html(s);

                  }
                });
              
            });
        });

//#################################add technician form#################################

$(function(){

            $('#addTechnicians').ajaxForm(function(){ 
                  
                  $.ajax({
                  url: "",
                  context: document.body,
                  success: function(s,x){
                    $(this).html(s);

                  }
                });
              
            });
        });
  //##########################end of addTechnician####################################

// #################################end for custom shop hours ##########################

$(function(){

   

            $('#coupon').ajaxForm(function(){ 
                  
                  $.ajax({
                  url: "",
                  context: document.body,
                  success: function(s,x){
                    $(this).html(s);
                    $('div#coupons').append("Your file Uploaded Successfully");

                  }
                });
              
            });
        });
// #################################end for coupon ##########################

$(function(){

            $this = $("#serviceName");
            $("#AddService").click(function(){

               if($this.val() == "")
                {
                  $this.css({
                  'border-color': 'red',
                  'border-width':'2px',
               });
                  $this.effect("shake", { times:3 }, 50);
                 
                 
                  return false;
                }
            

            });

            $('#addServices').ajaxForm(function(){ 
                  
                $.ajax({
                  url: "",
                  context: document.body,
                  success: function(s,x){
                    $(this).html(s);
                    $('#addServices').append("<span id='serviceAdded'>Service Added</span>");
                                      }
                });
              
            });
        });

// #################################end of Add services ##########################

$(function(){

  $("#appointmenttable td").click(function(){

      $(this).css({"backgroundColor": "green", "color": "white"});

  });

  $("td").dblclick(function(){
    

     $(this).css({"backgroundColor": "white", "color": "black"});
     //$(this) 
        
  });

// //////////////////////Delete Account start//////////////////////////////////
       $('a#delete').ajaxForm(function(){ 
                  
                $.ajax({
                  url: "",
                  context: document.body,
                  success: function(s,x){
                    $(this).html(s);
                    
                                      }
                });
              
            });
////////////////////////////////end of Delete////////////////////////////////////////
//////////////////////////////start of rewardAmmount///////////////////////////////

        
          $('#rewardAmmount').ajaxForm(function(){ 
                  
                $.ajax({
                  url: "",
                  context: document.body,
                  success: function(s,x){
                    $(this).html(s);
                    
                                      }
                });
              
            });

// //////////////////////////////ajax footer Links start/////////////////////////////////////////////
  
  // $("a#operationFooter").click(function(){
  //     $('#wrapper').load('/manage/operations #wrapper');
  //     return false;
  // });

  // $("a#couponsFooter").click(function(){
  //     $('#wrapper').load('/manage/coupons #wrapper');
  //     return false;
  // });

  // $("a#accountsFooter").click(function(){
  //     $('#wrapper').load('/member/accounts #wrapper');
  //     return false;
  // });

  // $("a#appointmentFooter").click(function(){
  //     $('#wrapper').load('/appointments/index #wrapper');
  //     return false;
  // });

  
/////////////////////////////////ajax footer links end///////////////////////////////////////////////
  
});

  $(function(){

     var val1 = $('tr#time2 label').text();
    $("#time2").addClass(val1);

    var val2 = $('tr#time3 label').text();
    $("#time3").addClass(val2);

    var val3 = $('tr#time4 label').text();
    $("#time4").addClass(val3);

    var val4 = $('tr#time5 label').text();
    $("#time5").addClass(val4);

    var val5 = $('tr#time6 label').text();
    $("#time6").addClass(val5);

    var val6 = $('tr#time7 label').text();
    $("#time7").addClass(val6);

    var val7 = $('tr#time8 label').text();
    $("#time8").addClass(val7);

    var val8 = $('tr#time9 label').text();
    $("#time2").addClass(val8);

    var val9 = $('tr#time10 label').text();
    $("#time3").addClass(val9);

    var val10 = $('tr#time11 label').text();
    $("#time4").addClass(val10);

    var val11 = $('tr#time12 label').text();
    $("#time5").addClass(val11);

    var val12 = $('tr#time13 label').text();
    $("#time6").addClass(val12);

    var val13= $('tr#time14 label').text();
    $("#time7").addClass(val13);

    var val14 = $('tr#time15 label').text();
    $("#time8").addClass(val14);

    var val15 = $('tr#time16 label').text();
    $("#time8").addClass(val15);

    var val16 = $('tr#time17 label').text();
    $("#time8").addClass(val16);

    var val17 = $('tr#time18 label').text();
    $("#time8").addClass(val17);
    
/////////////////////////////////////////////////////////////////////////
    $("#time2 input").val(val1);
    $("#time3 input").val(val2);
    $("#time4 input").val(val3);
    $("#time5 input").val(val4);
    $("#time6 input").val(val5);
    $("#time7 input").val(val6);
    $("#time8 input").val(val7);
    $("#time9 input").val(val8);
    $("#time10 input").val(val9);
    $("#time11 input").val(val10);
    $("#time12 input").val(val11);
    $("#time13 input").val(val12);
    $("#time14 input").val(val13);
    $("#time15 input").val(val14);
    $("#time16 input").val(val15);
    $("#time17 input").val(val16);
    $("#time18 input").val(val17);
    
  });


  function updateTextArea() {         
     var allVals = [];
     $('#appointmenttable :checked').each(function() {
       allVals.push($(this).val());
     });
     // $('#t').val(allVals)
     console.log(allVals);
  }

 $(function() {
   $('#appointmenttable input').click(updateTextArea);
   updateTextArea();
 });


 $(function(){

      $('#sunCloseAllDay').click(function(){

              
      });

 });




