$(document).ready(function(){
    /*stethoscope RATING*/
 
    $('.stethoscope').on("mouseover",function(){
        //get the id of stethoscope
        var stethoscope_id = $(this).attr('id');
        switch (stethoscope_id){
            case "stethoscope-1":
                $("#stethoscope-1").addClass('stethoscope-checked');
                break;
            case "stethoscope-2":
                $("#stethoscope-1").addClass('stethoscope-checked');
                $("#stethoscope-2").addClass('stethoscope-checked');
                break;
            case "stethoscope-3":
                $("#stethoscope-1").addClass('stethoscope-checked');
                $("#stethoscope-2").addClass('stethoscope-checked');
                $("#stethoscope-3").addClass('stethoscope-checked');
                break;
            case "stethoscope-4":
                $("#stethoscope-1").addClass('stethoscope-checked');
                $("#stethoscope-2").addClass('stethoscope-checked');
                $("#stethoscope-3").addClass('stethoscope-checked');
                $("#stethoscope-4").addClass('stethoscope-checked');
                break;
            case "stethoscope-5":
                $("#stethoscope-1").addClass('stethoscope-checked');
                $("#stethoscope-2").addClass('stethoscope-checked');
                $("#stethoscope-3").addClass('stethoscope-checked');
                $("#stethoscope-4").addClass('stethoscope-checked');
                $("#stethoscope-5").addClass('stethoscope-checked');
                break;
        }
    }).mouseout(function(){
        //remove the stethoscope checked class when mouseout
        $('.stethoscope').removeClass('stethoscope-checked');
    })
    
    var rating;

    $('.stethoscope').click(function(){
        //get the stethoscopes index from it id
        rating = $(this).attr("id").split("-")[1];
        var stethoscope_id = $(this).attr('id');

        switch (stethoscope_id){
            case "stethoscope-1":
                $("#stethoscope-1").addClass('stethoscope-checked-f');
                $("#stethoscope-2").removeClass('stethoscope-checked-f');
                $("#stethoscope-3").removeClass('stethoscope-checked-f');
                $("#stethoscope-4").removeClass('stethoscope-checked-f');
                $("#stethoscope-5").removeClass('stethoscope-checked-f');
                break;
            case "stethoscope-2":
                $("#stethoscope-1").addClass('stethoscope-checked-f');
                $("#stethoscope-2").addClass('stethoscope-checked-f');
                $("#stethoscope-3").removeClass('stethoscope-checked-f');
                $("#stethoscope-4").removeClass('stethoscope-checked-f');
                $("#stethoscope-5").removeClass('stethoscope-checked-f');
                break;
            case "stethoscope-3":
                $("#stethoscope-1").addClass('stethoscope-checked-f');
                $("#stethoscope-2").addClass('stethoscope-checked-f');
                $("#stethoscope-3").addClass('stethoscope-checked-f');
                $("#stethoscope-4").removeClass('stethoscope-checked-f');
                $("#stethoscope-5").removeClass('stethoscope-checked-f');
                break;
            case "stethoscope-4":
                $("#stethoscope-1").addClass('stethoscope-checked-f');
                $("#stethoscope-2").addClass('stethoscope-checked-f');
                $("#stethoscope-3").addClass('stethoscope-checked-f');
                $("#stethoscope-4").addClass('stethoscope-checked-f');
                $("#stethoscope-5").removeClass('stethoscope-checked-f');
                break;
            case "stethoscope-5":
                $("#stethoscope-1").addClass('stethoscope-checked-f');
                $("#stethoscope-2").addClass('stethoscope-checked-f');
                $("#stethoscope-3").addClass('stethoscope-checked-f');
                $("#stethoscope-4").addClass('stethoscope-checked-f');
                $("#stethoscope-5").addClass('stethoscope-checked-f');
                break;
        }
        /*
        $.ajax({
            url: "store_rating.php",
            type: "POST",
            data: {stethoscope:stethoscope_index,product_id:product_id},
            beforeSend: function(){
                stethoscope_container.hide(); //hide the stethoscope container
                result_div.show().html("Loading..."); //show the result div and display a loadin message
            },
            success: function(data){
                result_div.html(data);
            }
        });
        */
    });

    $('#poor').click(function(){
        $('#reviewcontent').val("Poor!");

    });
    
    $('#good').click(function(){
        $('#reviewcontent').val("Good!");

    });

    $('#excellent').click(function(){
        $('#reviewcontent').val("Excellent!");

    });


    $('#review').click(function(){
        var doctorid = $.trim($("#doctorid").val()),
            patientid = $.trim($("#patientid").val()),
            reviewtitle = $.trim($("#reviewtitle").val()),
            reviewcontent = $.trim($("#reviewcontent").val()),
            stethoscope_container = $(".stethoscope").parent(),
            reviewfinished = $('#reviewfinished');
 
        /*
        if((stethoscope_index != 0)  && (reviewtitle != "")){
            $.post("_postreview.php",{doctorid:doctorid, patientid:patientid, rating:rating, reviewtitle:reviewtitle, reviewcontent: reviewcontent}, function(data){
                 stethoscope_container.hide();
                 reviewfinished.show();
            });
        }
        */

        $.ajax({
            url: "_postreview.php",
            type: "POST",
            data: {doctorid:doctorid, patientid:patientid, rating:rating, reviewtitle:reviewtitle, reviewcontent: reviewcontent},
            success: function(data){
                stethoscope_container.html("<p>You have reviewed this doctor.</p><hr>");

            }
        });
    });

    //get message
    doctorid = $("#doctorid").val();
    //get new message every 2 second
    setInterval(function(){
        $(".reviewcontainer").load("_getreviews.php?did="+doctorid);

    }, 2000);
});