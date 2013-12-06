$(document).ready(function(){
	$('#dateSelector').change(function() {
	    window.location.href = window.location.pathname+'?workshop_nid='+$('#dateSelector').val();
	    return false;
	});
});