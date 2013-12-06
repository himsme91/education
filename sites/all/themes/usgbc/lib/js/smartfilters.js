$(document).ready(function(){
	$('#smartfilters').smartfilters();
	$('a.smartfilters-trigger, #smartfilters a').live('click', function(e){ e.preventDefault() });
	$('a.smartfilters-trigger').click(toggleSmartfilters);
});


// toggle smartfilters
function toggleSmartfilters(){
	var trigger = $('a.smartfilters-trigger');
	var smartfilters = $('#smartfilters');
	var basicsearch = $('.jumbo-search');
	
	if(trigger.hasClass('active')){
		trigger.removeClass('active');
		smartfilters.slideUp(function(){
			basicsearch.slideDown();
		});
	} else {
		trigger.addClass('active');
		basicsearch.slideUp(function(){
			smartfilters.slideDown();
		});
	};
};

var dateOptions = {
	changeMonth: true,
	changeYear: true,
	yearRange: '-10:+10',
	showOn: 'both',
	buttonImage: '/sites/all/themes/usgbc/lib/img/calendar_view_month.png',
	buttonImageOnly: true	                    	
}

var types = new Array();
var typeOptions = $('<div class="rule type"><select></select></div>');

var filters = [
	{
		full: 'LEED credential',
		short: 'leed',
		conditional: [
			'is',
			'contains',
			'is not'
		],
		value: {
			type: 'select',
			options: [
				'LEED Green Associate',
				'LEED AP BD+C',
				'LEED AP HOMES',
				'LEED AP ID+C',
				'LEED AP O+M'
			]
		}
	},
	{
		full: 'Location',
		short: 'location',
		conditional: [
			'within 10 miles',
			'within 25 miles',
			'within 50 miles',
			'within 75 miles',
			'within 100 miles'
		],
		value: { type: 'text' }
	},
	{
		full: 'Conduct date',
		short: 'date',
		conditional: null,
		value: { type: 'datepicker' }
	},
	{
		full: 'Format',
		short: 'format',
		conditional: [
			'is',
			'is not'
		],
		value: {
			type: 'select',
			options: [
				'Live',
				'On-demand'
			]
		}
	},
	{
		full: 'Rating',
		short: 'rating',
		conditional: [
			'is',
			'is at least',
			'is at most'
		],
		value: {
			type: 'select',
			options: [
				'&#10029;&#10025;&#10025;&#10025;&#10025;&nbsp;&nbsp;Horrible',
				'&#10029;&#10029;&#10025;&#10025;&#10025;&nbsp;&nbsp;Poor',
				'&#10029;&#10029;&#10029;&#10025;&#10025;&nbsp;&nbsp;Neutral',
				'&#10029;&#10029;&#10029;&#10029;&#10025;&nbsp;&nbsp;Good',
				'&#10029;&#10029;&#10029;&#10029;&#10029;&nbsp;&nbsp;Excellent'
			]
		}
	},
	{
		full: 'Keyword',
		short: 'keyword',
		conditional: null,
		value: { type: 'text' }
	}
];

var samples = [
	'leed',
	'location',
	'date'
];

for(var i = 0; i < filters.length; i++){
	types[i] = filters[i].short;
	typeOptions.find('select').append('<option value="' + filters[i].short + '">' + filters[i].full + '</option>');
};

$.fn.smartfilters = function(){
	var smartfilter = $(this);
	if(smartfilter.hasClass('preset-filters')){
  	 initializeFilter();
	} else {
  	 sampleFilters();
	} 
	$('.filter .type select', smartfilter).live('change', changeFilter);
	$('.filter .remove', smartfilter).live('click', removeFilter);
	$('.filter .add', smartfilter).live('click', addFilter);
	$('.smartfilter-clear', smartfilter).live('click', sampleFilters);
	$('.save', smartfilter).click(saveFilter);
	
	// change filter type
	function changeFilter(){
		var filter = $(this).parents('.filter');
		var type = $(this).val();
		
		filter.replaceWith(createFilter(type));
		initializeFilter();
	};	
	
	// create new filter
	function createFilter(type){
		var value;
		var conditional;
		var actions = '<ul class="actions"><li class="add"><a href=""><span>Add another filter</span></a></li><li class="remove"><a href=""><span>Remove this filter</span></a></li></ul>';
		var filterNum = parseInt(getIndex(type));
		
		// set conditionals
		if(type == 'keyword' || type == 'date'){
			conditional = '';
		} else {
			conditional = '<option value=""></option>';
			for(var i = 0; i < filters[filterNum].conditional.length; i++){
				conditional = conditional + '<option value="' + filters[filterNum].conditional[i] + '">' + filters[filterNum].conditional[i] + '</option>';
			};
			conditional = '<select>' + conditional + '</select>';
		};
		
		// value is text string
		if(type == 'location' || type == 'keyword'){
			value = '<input type="text" class="field lg" />';
		};
		
		// value is select
		if(type == 'leed' || type == 'format' || type == 'rating'){
			value = '<option value=""></option>';
			for(var i = 0; i < filters[filterNum].value.options.length; i++){
				value = value + '<option value="' + filters[filterNum].value.options[i] + '">' + filters[filterNum].value.options[i] + '</option>';
			};
			value = '<select>' + value + '</select>';
		};
		
		// value is datepicker
		if(type == 'date'){
			value = '<div class="left date"><input class="datepicker field" type="text" name="" value="From" /></div><div class="left date"><input class="datepicker field" type="text" name="" value="To" /></div>'
		};
		
		var type_menu = $(typeOptions).clone();
		$('select',type_menu).val(type);
		
		var newFilter = $('<fieldset class="filter new"><div class="rule type"></div><div class="rule conditional">' + conditional + '</div><div class="rule value">' + value + '</div>' + actions + '</fieldset>');
		newFilter.find('.rule.type').append(type_menu);
		return newFilter;
	};
	
	// remove filter
	function removeFilter(){
		var filterCount = $('.filter', smartfilter).length;
		
		if(filterCount == 1) { 
			return false;
		} else {
			$(this).parents('.filter').animate({
				opacity: 0,
				height: 0
			}, 150, function(){ 
				$(this).remove();
				if((filterCount - 1) == 1){
					$('.filter .actions .remove', smartfilter).hide();
				};
			});
		};
	};
	
	// add filter
	function addFilter(){
		var filter = $(this).parents('.filter');
		var type = $('.type select', filter).val();
		
		if($('.actions .remove', filter).is(':hidden')){
			$('.actions .remove', filter).fadeIn(200);
		};
		
		filter.after(createFilter(type));
		initializeFilter();
	};
	
	// sample filters
	function sampleFilters(){
		$('#filter-set .filter', smartfilter).remove();
		for(var i = 0; i < samples.length; i++){
			var type = samples[i];
			$('#filter-set', smartfilter).append(createFilter(type));
		};
		initializeFilter();
	};
	
	// get type index
	function getIndex(type){
		for(var i = 0; i < types.length; i++){
			if(types[i] == type){ return i };
		};
	};
	
	// initialize new filter
	function initializeFilter(){
	 
		var newFilter = $('.filter.new', smartfilter);
		
		newFilter.each(function(){
  		$('select', this).uniform();
  		$('.datepicker', this).datepicker(dateOptions);
  		$(this).removeClass('new');
		});
		
	};
	
	// save filter
	function saveFilter(e){
		e.preventDefault();
		var saveFields = '<div class="right"><form method="get" action="/courses/list-inperson.php"><input type="hidden" name="q" value="saved_filter" /><input class="left field lg filtername" type="text" value="Enter your filter name" /><input type="submit" class="small-alt-button left save" value="Save" /></form></div>';
		$(this).parent('.button-group').html(saveFields);
		$('input.filtername').autoclear();
	};
};