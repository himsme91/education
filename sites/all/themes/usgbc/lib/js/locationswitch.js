$(document).ready(function(){

    $('#locations').children().hide();
    $('#locationSelector').change(function(){
    	$('#'+this.value).show().siblings().hide();
    });
    $('#locationSelector').change();

}
	
);