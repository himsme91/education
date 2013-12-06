(function($){
	var Card, cards;
	cards = [];
	
	$(document).ready(function(){
		$('#experts .card').each(function(){
			var newCard = new Card({ $el: $(this) });
			cards.push(newCard);
		});
	});
	
	Card = function(options){
		if(!options.$el) throw 'Card class requires a DOM element assigned to $el'
		this.$el = options.$el;
		this.profileUrl = this.$el.attr('data-profile-url');
		this.speakUrl = '/prototype/themes/usgbc/lib/inc/modals/request-speaker.php?name=' + this.$el.attr('data-name-slug');
		this.interviewUrl = '/prototype/themes/usgbc/lib/inc/modals/request-interview.php?name=' + this.$el.attr('data-name-slug');
		
		this.appendButtons();
	};
	
	Card.prototype = {
		appendButtons: function(){
			this.$el.append(
				'<div class="btn-row">' + 
			//	'	<a href="' + this.speakUrl + '" class="btn btn-success speak jqm-trigger" title="Request as speaker" data-js-callback="init_request"></a>' +
			//	'	<a href="' + this.interviewUrl + '" class="btn btn-dark interview jqm-trigger" title="Request an interview" data-js-callback="init_request"></a>' +
				'	<a href="' + this.profileUrl + '" class="btn btn-primary profile" title="View profile"></a>' +
				'</div>'
				
				//<a class="jqm-trigger" href="/prototype/themes/usgbc/lib/inc/modals/set-location.php">
			);
		}
	}
})(jQuery);