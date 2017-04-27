$(document).ready(function(){
    /*post message via ajax*/
    $("#send").on("click", function(){
        var messagecontent = $.trim($("#messagecontent").val()),
            friendid = $.trim($("#friendid").val()),
            sentby = $.trim($("#sentby").val()),
            error = $("#error");
 
        if((messagecontent != "") && (friendid != "") && (sentby != "")){
            error.text("Sending...");
            $.post("_postmessage.php",{messagecontent:messagecontent, friendid:friendid, sentby:sentby}, function(data){
                error.text(data);
                //clear the message box
                $("#messagecontent").val("");
            });
        }
    });
 
    id = $("#id").val();
    setInterval(function(){
         $(".messagesidebar").load("_messagesidebar.php?id"+id);
     }, 1000);
    
    //get message
    friendid = $("#friendid").val();
    
    setInterval(function(){
        $(".display-message").load("_getmessage.php?friendid="+friendid);

    }, 1000);
    

    
    //$(".display-message").scrollTop(0, $(".display-message")[0].scrollHeight);

 $('#chatarea').animate({
        scrollTop: $('#chatarea')[0].scrollHeight}, 2000);
});