(function($) {
	jQuery.fn.externalLinks = function() {
	  return this.each(function(){
	     
		    $(this).attr('target','_blank');

	  });
	};

})(jQuery);