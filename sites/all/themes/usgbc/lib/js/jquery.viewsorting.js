$(document).ready(function(){
	
	$('.url-menu').change(function(event){ location.href = $(this).val(); });
  
    $('#items-sort-selector select').change(function(){
    	
    	var urlParams = decodeURI( window.location.search.substring(1) ); 
    	
    	if(urlParams == false | urlParams == ''){
    		window.location = '?' + $(this).val();
    	}else{

    		var pars = urlParams.split(/[&;]/g);
    		
    		var org = $(this).val();
    		
    		var orglist = org.split(/[&;]/g);
    		
    		for (var k= orglist.length; k-->0;){
    
    			var prefix = encodeURIComponent(orglist[k].split('=')[0])+'=';
    		
    			   for (var i= pars.length; i-->0;)              
    	    	          if (pars[i].lastIndexOf(prefix, 0)!==-1)   
    	    	              pars.splice(i, 1);
    			  
    		}
    			   		 
    	      if (pars.join('&') == ''){
    	    	  window.location = '?' + $(this).val();
    	      }else{
    	    	  window.location = '?' + $(this).val() + '&' + pars.join('&');
    	      }
    		
    	   		
    		
    	}
    
  	});
  	
});