$(document).ready(function(){
	$('#control a').click(function(e){
		e.preventDefault();
		var state = $(this).closest('li').attr('class');
		console.log(state);
		
		$('#control .active').removeClass('active');
		$(this).closest('li').addClass('active');
		
		if(state == 'profile-on'){
			$('body').removeClass('profile-off').addClass(state);
			$('#control p').text('Your directory listing can link to a profile. To create the profile, fill out the information below. Once the required sections are completed, a profile will automatically be created for you.');
		}
		
		if(state == 'profile-off'){
			$('body').removeClass('profile-on').addClass(state);
			$('#control p').text('Your name will not be listed in our online directory.');
		}
	});
	
	$('#control .profile-off a').click();
});