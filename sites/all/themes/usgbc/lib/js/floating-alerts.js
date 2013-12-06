$(document).ready(function () {
	
	
	$('#alerts-container').load('/user/notifications',function(reponse,status,xhr){
		if(status == 'success'){
			
			$('#alerts-container #close-alerts').click(function () {
			    hideAlerts();
			    return false;
			});
			 
			$('#alerts-container #alerts-button').click(function () {
				$('#alerts-bar, #alerts-container #alerts-nav').addClass('bar-active');
				return false;
			});	
			
			
		}
	});
	
	
	function hideAlerts() {
		$('#alerts-bar, #alerts-container #alerts-nav').removeClass('bar-active');
	}

	
});