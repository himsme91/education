$(document).ready(function () {
	
	
	$('#alerts_section').load('/user/notifications #alert-main',function(reponse,status,xhr){
		if(status == 'success'){}
	});
	
	
};