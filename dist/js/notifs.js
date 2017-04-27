$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"_readnotifs.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.dropdown-menu').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
   }
  });
 }
 
 $(document).on('click', '.dropdown-toggle', function(){
  $('.count').html('');
  load_unseen_notification('yes');
 });

 var type = $("#type").val();
 var id = $("#id").val();
 setInterval(function(){
     $(".messagecount").load("_messagecount.php?id="+id+"&type="+type);

 }, 1000);
    

 
});