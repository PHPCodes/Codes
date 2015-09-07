var host = window.location.host;
var proto = window.location.protocol;
var ajax_url = proto+"//"+host+"/cybercoupon/";

$(document).ready(function(){
	setTimeout( function() {$('.succ_msg').hide();}, 4*1000);
	setTimeout( function() {$('.success').hide();}, 4*1000);
	
});

function handle(event){
        if(event.keyCode === 13){
            searching();
        }

        return false;
    }
