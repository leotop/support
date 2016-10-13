$(function(){
    $("body").on("change", ".ticket-in-work input", function(){     
        var ticket_id = parseInt($(this).data("ticket-id"));
        var url = document.location.href;
        if (ticket_id > 0) {
            if (url.indexOf("?") > 0) {
                url = url + "&ajax=yes&update_ticket_work_status=" + ticket_id
            } else {
                url = url + "?ajax=yes&update_ticket_work_status=" + ticket_id
            }
            var container_id = "#ticket-in-work-" + ticket_id;
            $(container_id).load(url + " " + container_id + " > *");  
        }
    })
})