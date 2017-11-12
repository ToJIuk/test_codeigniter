$(function(){

    // ---------------------------------------- PRO Request ---

    $('.pro_order_btn').on('click', function(){

        $.get('/ajax_api/pro_request/', function(data){
            alert('Saved!');
        });

    });

});

// Debug Function
function dump_alert(obj) {
    var out = "";
    if(obj && typeof(obj) == "object"){
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }
    } else {
        out = obj;
    }
    alert(out);
};