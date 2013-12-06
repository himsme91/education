(function($){
	$(document).ready(function(){
		$('.jumbo-search').each(function(){
			if($(this).find('.quick-filter').size() < 1) return;
			var search = new SmartSearch({ el: $(this) });
		});
	});
	
	var SmartSearch = function(options){
		this.init(options.el);
	};

	SmartSearch.prototype = {
		init: function(el){
			this.$el = el;
			this.field = this.$el.find('input[type="text"]');
			this.filterList = this.$el.find('.quick-filter');
			this.filterListOpen = false;
			this.activeFilter = 'All';
			
			this.setEvents();
		},
		
		setEvents: function(){
			var self = this;
			
			this.field.bind({
				keyup: function(){
					var query = self.field.val();
					self.setMarksTo(query);
					
					if(query.length > 4 && !this.filterListOpen) return self.showFilterList();
					self.hideFilterList();
				}
			});
			
			this.filterList.find('a').bind({
				mouseenter: function(){
					self.filterList.find('.active').removeClass('active');
					$(this).closest('li').addClass('active');
					self.activeFilterChange();
				},
				
				click: function(e){
					e.preventDefault();
					self.submitQuery();
				}
			});
		},
		
		setMarksTo: function(string){
			this.filterList.find('.mark').text(string);
		},
		
		showFilterList: function(){
			if(this.filterListOpen) return;
			this.filterList.slideDown(200);
			this.filterListOpen = true;
			this.bindArrowKeys();
		},
		
		hideFilterList: function(){
			if(!this.filterListOpen) return;
			this.filterList.slideUp(200);
			this.filterListOpen = false;
			this.filterList.find('.active').removeClass('active');
			this.filterList.find('li:first-child').addClass('active');
			this.unbindArrowKeys();
		},
		
		bindArrowKeys: function(){
			var self = this;
			this.field.bind('keydown', function(e){
				if(e.keyCode !== 38 && e.keyCode !== 40 && e.keyCode !== 13) return;
				e.preventDefault()
				if(e.keyCode === 38) return self.prevFilter();
				if(e.keyCode === 40) return self.nextFilter();
				self.submitQuery();
			});
			
			$(window).bind({
				click: function(e){
					if($(e.target).is(self.$el) || $(e.target).parents().is(self.$el)) return;
					self.hideFilterList();
				}
			});
		},
		
		unbindArrowKeys: function(){
			this.field.unbind('keydown');
			$(window).unbind('click');
		},
		
		prevFilter: function(){
			if(this.filterList.find('li:first-child').hasClass('active')) return;
			this.filterList.find('.active').removeClass('active').prev('li').addClass('active');
			this.activeFilterChange();
		},
		
		nextFilter: function(){
			if(this.filterList.find('li:last-child').hasClass('active')) return;
			this.filterList.find('.active').removeClass('active').next('li').addClass('active');
			this.activeFilterChange();
		},
		
		activeFilterChange: function(){
			if(this.filterList.find('.active .filter').size() < 1) return this.activeFilter = 'All';
			this.activeFilter = this.filterList.find('.active .filter').text();
		},
		
		submitQuery: function(){
			
			// If filter is set to all, perform regular search
			if(this.activeFilter === 'All') return this.$el.find('input[type="submit"]').click();
			
			// Else, run a filtered search.
			// *** Here is where the fuction to actually execute the search should go.
			var query = this.field.val();
			alert('Search for "' + query + '" in "' + this.activeFilter + '".');
		}
	};
})(jQuery);