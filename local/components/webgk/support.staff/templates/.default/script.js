$(function(){
    $("body").on("click", ".show-info-link", function(){     
        $(".info-popup-container").fadeOut();   
        $(this).siblings(".info-popup-container").fadeIn();   
    })

    $("body").on("click", function(e){     
        if(!$(e.target).parents().hasClass("info-popup-container") && !$(e.target).hasClass("show-info-link")) {
            $(".info-popup-container").fadeOut();
        }   
    })

    $("body").on("click", ".ticket-tracking-close", function(){     
        $(this).parent(".info-popup-container").fadeOut();   
    })

})