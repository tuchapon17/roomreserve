$(function(){
	$("#logout_menu").on("click",function(){
		bootbox.confirm("คุณต้องการออกจากระบบหรือไม่?",function(result){
			if(result==true) window.location="?c=login&m=logout";
		});
	});
});
function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}