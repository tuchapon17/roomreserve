function nav_bar_link()
{
	$("#view_profile").on("click",function(){
		window.location="?c=user_profile&m=view_profile";
	});
	$("#edit_profile1").on("click",function(){
		window.location="?c=user_profile&m=edit_profile1";
	});
	$("#edit_profile2").on("click",function(){
		window.location="?c=user_profile&m=edit_profile2";
	});
	$("#edit_profile3").on("click",function(){
		window.location="?c=user_profile&m=edit_profile3";
	});
}
function active_tab()
{
	//active_tab by id/URL parameter 'm'
	$("#"+getURLParameter("m")).tab('show');
}