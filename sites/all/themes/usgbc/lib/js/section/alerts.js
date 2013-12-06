     $(document).ready(function(){
    
        // count alerts & activities
        alertCount();
        activityCount();
    
    
        // Jscroll initiation
        $('.activities').jScrollPane({
        	showArrows: true,
        	autoReinitialise: true
        });
        
        
        $('.filter-menu a').click(function(e){
        	e.preventDefault();
        	
        	var filter = $(this).attr('class').replace('filter-', '').replace('s', '');
        	var feed = $('#activity-list');
        	var list = $('.activities', feed);
        	
        	$('.selected', feed).removeClass('selected');
        	$(this).parents('li').addClass('selected');
        	
        	if(filter == 'all'){ $('li', list).show() } else {
        		$('li.' + filter, list).show();
        		$('li:not(.' + filter + ')', list).hide();
        	};
        }); 
        
        $('.close-btn, .alert-dismissal').click(function(e){
        	e.preventDefault();
        	
        	var type = $(this).attr('class');
        	var id = $(this).attr('id');
        	 $.ajax({
                 type: 'POST',
                 url: '/myaccount/deletealert'+ '/' + id,
                 dataType: 'json', //define the type of data that is going to get back from the server
                 data: "js=1",//'{' + paramCC + '}',
                 success:  function(msg) {
                	 $(this).parents('li').fadeOut(50, function(){
                 		$(this).remove();
                 		if(type == 'close-btn'){ activityCount() } else if(type == 'alert-dismissal'){ alertCount() };
                 	});
                 }
               });	
        });
        
        $('.alert-expand a').click(function(e){
        	e.preventDefault();
            $('#attention-feed ul li:gt(5)').show();
            $(this).parents('.alert-expand').remove();
    	});
               
    });
    
    function activityCount() {
        if ($('.activities li').length == 0){
        	$('.activities').after('<p class="no-alerts">There are no alerts</p>').hide()
        }
    };

    function alertCount(){
        var alertcount = $('#attention-feed li:visible').length;
        
        if (alertcount == 0){ 
            $('#attention-feed ul').append('<p class="no-alerts">There are no alerts</p>');
        } else if (alertcount > 4){
            $('#attention-feed ul').append('<p class="alert-expand"><a class="more-link" href="">Show all alerts</a></p>');
            $('#attention-feed ul li:gt(5)').hide();
        }
    };    
