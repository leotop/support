$(function() {
    $(".work-report-form textarea").on("keyup", function() {
        var res = true;
        $(".work-report-form textarea").each(function(){
            if (!$(this).val()) {
                res = false; 
            } 
        })

        if (res) {
            $("#submit-report").removeAttr("disabled"); 
        } else {
            $("#submit-report").attr("disabled", "disabled"); 
        }
    })
})