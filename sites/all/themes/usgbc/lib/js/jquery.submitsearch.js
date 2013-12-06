$(document).ready(function(){
	$('#browseCourse').click(function() {
	    window.location.href = '/courses/in-person?search='+$('#searchinput').val();
	    return false;
	});
});