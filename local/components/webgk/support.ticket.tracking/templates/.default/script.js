$(function(){
    $("body").on("click", ".ticket-tracking-control", function(){     
        $("#ticket-tracking-container").fadeToggle();   
    })
    
    $("body").on("click", function(e){     
       if(!$(e.target).parents().hasClass("ticket-tracking-container-wrapper") && !$(e.target).hasClass("ticket-tracking-control")) {
           $("#ticket-tracking-container").fadeOut();
       }   
    })
    
})