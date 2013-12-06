
$(document).ready(function(){
	$(".tooltip").data('timeoutId',"");
	$(".tooltip").data('timeId',"");
	$(".tooltip").data('toolId', "");
	//$(".tooltip").data('time',0);
	$(".tool").live('mouseenter',function(e){ //event fired when mouse cursor enters "a" element
		//alert($(".tooltip").data("time"));
		if($(".tooltip").data('toolId') != $(this).find(".id").text()){
			
		clearTimeout($(".tooltip").data('timeoutId'));
		$(".tooltip").data('timeoutId',"");
		$(".tooltip").hide().queue(function () {
		    
	        $(this).remove();
	        $(this).dequeue();
         }
		
     );
	}
		else{
			clearTimeout($(".tooltip").data('timeoutId'));
			$(".tooltip").data('timeoutId',"");
		}

		var tip = $(this);
		var tool_id = $(this).find(".id").text();
		timeId = setTimeout(function(){
	    var $class_name = "usgbc"; //get class attribute of "a" element after leaving 13 characters which is equal to "tooltip_link "
	    //var $x = e.pageX - this.offsetLeft; //get mouse X coordinate relative to "a" element
	    var $tooltip_text = "some";
	    var title = tip.find("h4").text(); //get title attribute of "a" element
		var five_star = tip.find(".five-star").html();
		var ce = tip.find(".CE").html();
		if (ce == null){
			ce = "";
		}

		//ce.removeClass("right");	
		locate = tip.offset();
		//alert(locate.left+"+"+locate.top);
		var id = tip.find(".id").html();
		var level = tip.find(".level").html();
		var summary = tip.find(".summary").html();
		var provider = tip.find(".provider").html();
		var leed = tip.find(".leed-badge").html();
		var link = tip.find(".tooltip_link").attr("href");
		var content = ('<div class="tooltip shadow-left arrow-left ' + $class_name + '"><div class="tool-head">'
					+'<div class="title"><a href="'+link+'">'+ title +'</a></div>'
					+'<div class="group1"><div class="left">'+five_star+'</div>'
					+'<div class="badges">'+leed+'</div></div>'
					+'<div class="group2">'+id+'<div class="meta-item ce">'+ce+'</div>'+level+'</div>'
					+ '</div>'
					+'<div class="tool-body">'
					+'<div class="summary">'+summary+'</div>'
					+'<div class="provider">'+provider+'</div>'
					+'</div></div>'
				); 
				
	    if ($tooltip_text.length > 0) { //display tooltip only if it has more than zero characters
	        tip.parent().append(content); //append tooltip markup, insert class name and tooltip title from the values above
	       // $("a > div.tooltip.center").css("left", "" + $x - 103 + "px"); //set tooltip position from left
	        //var pos = locate.left +150;
	        if(locate.left>700){
	        	$(".tooltip").removeClass("arrow-left");
	        	$(".tooltip").addClass("arrow-right");
	        	$(".tooltip").removeClass("shadow-left");
	        	$(".tooltip").addClass("shadow-right");
	        	$(".tooltip").css("margin-left", "-350px");
		    }
	        //$(".tooltip").css("left", "" + pos + "px"); //set tooltip position from left
	        //$(".tooltip").css("top", "" + locate.top - 50 + "px");
	        //$("a > div.tooltip.right").css("left", "" + $x - 208 + "px"); //set tooltip position from left
	        $(".tooltip." + $class_name).fadeIn('slow'); //display, animate and fade in the tooltip
	        //$("#left").css("left",""+locate.left+"px");
	        //$("#left").css("top",""+parseInt(locate.top)+ "px");
	        //$("#left").fadeIn(300);
	    }
	    
		},500);
		$(".tooltip").data('toolId', tool_id);
		$(".tooltip").data('timeId', timeId);
	});
	 $(".tool").live('mouseleave',function(){ //event fired when mouse cursor leaves "a" element

		 clearTimeout($(".tooltip").data('timeId'));
		 $(".tooltip").data('timeoutId',"");
		 $(".tooltip").data('toolId', "");
		 
		 $(".tooltip").live('mouseenter',function(){
			//alert();
			$(".tooltip").addClass("hover");
	});
		$(".tooltip").live('mouseleave',function() {
			  
			$(".tooltip").fadeOut(300).queue(function () {
		        $(this).remove();
		        $(this).dequeue();
	         }
	     );
	        
	});
		timeoutId = setTimeout(function(){
			
						
			if($(".tooltip").hasClass("hover")){

				
			}else{
				clearTimeout($(".tooltip").data('timeId'));
				 $(".tooltip").data('timeoutId',"");
				 $(".tooltip").data('toolId', "");
					$(".tooltip").fadeOut(300).queue(function () {
				    
				        $(this).remove();
				        $(this).dequeue();
			         }
			     );	
				}
			},500);
		$(".tooltip").data('timeoutId', timeoutId);
		//$(".tooltip").data('time', 1);
		
        
});

});