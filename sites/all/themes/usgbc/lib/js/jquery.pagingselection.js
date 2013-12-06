$(document).ready(function(){
	
$('#pagesize-selector select').change(function(){

	var urlParams = decodeURI( window.location.search.substring(1) ); 
	
	if(urlParams == false | urlParams == ''){
		window.location = '?pagesize=' + $(this).val();
	}else{
		
		var prefix = encodeURIComponent('pagesize')+'=';
		var pars = urlParams.split(/[&;]/g);
	
	      for (var i= pars.length; i-->0;)               
	          if (pars[i].lastIndexOf(prefix, 0)!==-1)   
	              pars.splice(i, 1);
	      
	      if (pars.join('&') == ''){
	    	  window.location = '?pagesize=' + $(this).val();
	      }else{
	    	  window.location = '?pagesize=' + $(this).val() + '&' + pars.join('&');
	      }
	      
	}
	
});
});