<style type="text/css">
select {
	padding: 11px !important;
}
</style>
<?php

$current_display = $view->current_display;
$view_name = $view->name;
$current_smartf = 'smartf_'.$view_name.'_'.$current_display;

$existing_smartf = $_SESSION[$current_smartf];
$existing_smartf = str_replace('LOWER(node.title)) like \'%%%\'', "", $existing_smartf);

//the following code parses a smartfilter query string
//$existing_fields is created with what is parsed
if($existing_smartf){

	$existing_smartf 	= str_replace("(" ,"", $existing_smartf);
	$existing_smartf 	= str_replace(")" ,"", $existing_smartf);
	$existing_smartf 	= str_replace("..." ,"", $existing_smartf);

	//cut up the query string where a boundary is either AND or OR
	$conditions 		= preg_split("/  AND|OR  /", $existing_smartf);

	foreach($conditions as $condition){
		$field_values 	= explode(".",$condition);
		$field_values 	= $field_values[1];

		if(inStr($field_values,"like")){
			$separator = 'like'; 	$operator = 'contains';
		}
		else if(inStr($field_values,"=")){
			$separator = '='; 	$operator = 'is';
		}
		else if(inStr($field_values,"<>")){
			$separator = '<>';	$operator = 'is not';
		}
		else if(inStr($field_values,"BETWEEN")){
			$separator = 'BETWEEN';	$operator = 'between';
		}
		else {$separator = 'like'; 	$operator = 'contains';
		}

		$field_values 	= explode($separator, $field_values);
		$field_name 	= trim($field_values[0]);
		$field_value	= $field_values[1];

		if($separator == "like") $field_value = trim(str_replace("%","",$field_value));
		if($separator == "BETWEEN") {
			// This means that the field is a date and we need the lower and upper dates
			$field_value_dates = explode("AND", $field_value);

			$field_value_lower = trim($field_value_dates[0]);
			$field_value_upper = trim($field_value_dates[1]);
			$existing_fields[$field_name][$field_value_lower]['value_lower'] 	= $field_value_lower;
			$existing_fields[$field_name][$field_value_lower]['value_upper'] 	= $field_value_upper;
			$existing_fields[$field_name][$field_value_lower]['operator'] 		= $operator;

		} else {
			$existing_fields[$field_name][$field_value]['value'] 	= trim($field_value);
			$existing_fields[$field_name][$field_value]['operator'] = $operator;
		}
	}
}

$currenturl = explode("?", $_SERVER['REQUEST_URI']);

//Get the smart filter id from the request
$smartf_id = $_REQUEST['smartfid'];
//if id not present in the request check the session
//if (!$smartf_id) $smartf_id = $_SESSION[$smartfilterid];

//Get the name of the smart filter based on the id passed by the user as a request
if($smartf_id){
	$query = "SELECT filter_name FROM usgbc_smart_filters WHERE filter_id = '".$smartf_id."'";
	$smartf_name = db_result(db_query($query));
}
?>
<script>
var filters = [
<?php
foreach($view->field as $ff_id=>$ff){
//dsm($ff->content_field['type'])
	
	$content_field 	= $ff->content_field;
	
	$ff_title 		= $content_field['widget']['label'];
	$ff_name 		= $content_field['field_name'];
	$ff_type 		= $content_field['type'];
	$ff_table 		= $ff->table_alias;
	//dsm($ff_table);
	$ff_alias		= $ff->table_alias . "." . $ff->field;
	
	if(!$content_field && ($ff->real_field == 'title' || $ff->real_field == 'city' || $ff->real_field == 'province' || $ff->real_field == 'country')){
		
		$ff_title 	= $ff->definition['title'];
		if($ff->real_field == 'title') { 
			if ($ff->options['label']){ 
				$ff_title 	= $ff->options['label'] ;
			}
			else{
				$ff_title 	= 'Name';
			}
		}
		$ff_type 	= 'text';
		$ff_name 	= $ff->real_field;
		if($ff_title == 'Province') $ff_title = 'State';
	}

	if($ff->real_field == 'field_credit_points_possible_upp_value' 
		|| $ff->real_field == 'field_credit_points_possible_low_value' 
		|| $ff->real_field == 'field_org_show_name_in_dir_value' 
		|| $ff->real_field == 'field_per_fname_value'
		|| $ff->real_field == 'field_per_leedcred_value' 
		|| $ff->real_field == 'field_per_lname_value' 
		|| $ff->real_field == 'field_related_chp_nid' 
		|| $ff->real_field == 'field_related_org_nid' 
		|| $ff->real_field == 'field_per_associations_value' 
		|| $ff->real_field == 'field_per_show_name_in_dir_value'
		|| $ff->real_field == 'field_crs_pvd_nid'){
		$ff_title = '';
		$ff_name = '';
		$ff_type = '';
		$ff_table = '';
		$ff_alias = '';
	}
	
	if($ff_title != '' && !inStr($ff_type,'file')){
		
		if(inStr($ff_type,'taxonomy')){
			$allowed_values = usgbc_smartfilter_content_taxonomy_allowed_values($content_field, false);
		} else {
			$allowed_values = content_allowed_values($content_field, false);
		}
	
		if(empty($allowed_values)){
			$type = "text";
		} else {
			$type = "select";
		}
		if(inStr($ff_type,'date')) $type = 'date';
		?>
		{
		full: '<?php print $ff_title; ?>',
		shorts: '<?php print $ff_id; ?>',
		alias: '<?php print $ff_alias; ?>',

		<?php if($type == 'select'){ ?>
			conditional: ['is','is not'],
		<?php }else if ($type == 'text'){?>
			conditional: ['contains'],
		<?php }else{?>
			conditional: null,
		<?php }?>

		value: {
			type: '<?php print $type; ?>'
			<?php
			if(!empty($allowed_values)){
				$options = ',options:[';
				foreach($allowed_values as $allowed_key=>$allowed_value){
					if($allowed_key!='') $options = $options."'".$allowed_key."_".$allowed_value."',";
				}
				$options = $options."]";
			}
			print $options;
			?>
		}
		},
<?php
	}
}?>
];

var samples = [
<?php

if($existing_fields){
	foreach($view->field as $ff_id=>$ff){
		$content_field 	= $ff->content_field;
		if(($content_field['widget']['label'] != '' || $ff->real_field == 'title' || $ff->real_field == 'city' || $ff->real_field == 'province' || $ff->real_field == 'country') && !inStr($content_field['type'],'file')){
			if($existing_fields[$ff_id])
			foreach($existing_fields[$ff_id] as $existing_field) print "'".$ff_id."',";
		}

	}
} else {
	$i=1;
	
	foreach($view->field as $ff_id=>$ff){
		$content_field 	= $ff->content_field;
		
		$count = 1;
		
		if($i <= $count)
		if(($content_field['widget']['label'] != '' || $ff->real_field == 'title'  || $ff->real_field == 'city' || $ff->real_field == 'province' || $ff->real_field == 'country') && !inStr($content_field['type'],'file')){
			$i++;
			print "'".$ff_id."',";
		}

	}
}
?>

];


</script>



<script>

var blackListArray = [
						/* Primary & Applicable Rating System */		          		
		          		'Schools – Existing Buildings',	
		          		'Retail – Existing Buildings',
		        		'Hospitality – New Construction',
		        		'Hospitality – Existing Buildings',
		        		'Hospitality – Commercial Interiors',
		        		'Data Centers – New Construction',
		        		'Data Centers – Existing Buildings',
		        		'Warehouses and Distribution Centers – New Construction',
		        		'Warehouses and Distribution Centers – Existing Buildings',
		        		'Neighborhood Development Plan',
		        		
		        		/* 	Rating System Version */
		        		'v4 draft'//,

		        		/* Testing values */
						//'Commercial interiors',
						//'LEED Interpretations'
		        		];
		
<?php $currenturl = explode("?", $_SERVER['REQUEST_URI']); ?>
<?php if($currenturl[0] == '/leed-interpretations'): ?>
	$(document).ready(function(){
<?php else: ?>
	$(window).load(function() {
<?php endif; ?>	
	$('#navCol').prepend('<a class="smartfilters-trigger" href="#">Smart filters</a>');
	$('#smartfilters').smartfilters();
	$('a.smartfilters-trigger, #smartfilters a').live('click', function(e){ e.preventDefault() });
	toggleSmartfilters();
	$('a.smartfilters-trigger').click(toggleSmartfilters);
		
	<?php
		if($existing_fields)
		foreach($existing_fields as $field_name=>$existing_field){
			foreach($existing_field as $fieldv){
				$field_value        = $fieldv['value'];
				$field_value_lower  = $fieldv['value_lower']; // Lower date
				$field_value_upper  = $fieldv['value_upper']; // Upper date
				$operator           = $fieldv['operator'];
				$classname          = "'.".$field_name."'";
				$operator_classname = "'.".$field_name."_operator'";
				$field_value        = str_replace("'","", $field_value );
				if(!is_numeric( $field_value )){
					$field_value = "'" . $field_value . "'";
				}
				?>
				var previous = null;
				$(<?php print $classname?>).each(function(){
				<?php if(!$field_value_lower){ ?>
						//if there are multiple fields of this type: 
						// #1 Leave the unique values to do their updating
						// #2 remove duplicates

						if($(this).val() == '' || $(this).val() == null){
							if(previous){
								if(previous.val() != <?php print $field_value ?>){
									$(this).val(<?php print $field_value ?>);
									$(this).parent().parent().parent().find(<?php print $operator_classname?>).val('<?php print $operator?>') ;
									$.uniform.update();
									previous = $(this);
								}
							} else {
								$(this).val(<?php print $field_value ?>);
								$(this).parent().parent().parent().find(<?php print $operator_classname?>).val('<?php print $operator?>');
								$.uniform.update();
								previous = $(this);
							}
						} 
					
				<?php } else { ?>

						// This is when the field had a date comparison
						// This if/else block deals with single date fields and multiple date fields	
						if($(this).val() == 'From' || $(this).val() == 'To'){
							if(previous){
								if(previous.val() != (<?php print $field_value_lower?>)){
									$(this).parent().parent().find('.datepicker').each(function(){
										if($(this).hasClass('datefrom')){
											var datefrom = <?php print $field_value_lower?>;
											$(this).val(manipulate_date('ADD',datefrom,1)); 
											previous = $(this);
										}
										if($(this).hasClass('dateto')){
											var dateto = <?php print $field_value_upper?>;
											$(this).val(manipulate_date('SUBTRACT',dateto,1));
										}
									});
								}
							} else {
								$(this).parent().parent().find('.datepicker').each(function(){
									if($(this).hasClass('datefrom')){
										var datefrom = <?php print $field_value_lower?>;
										$(this).val(manipulate_date('ADD',datefrom,1)); 
										previous = $(this);
									}
									if($(this).hasClass('dateto')){
										var dateto = <?php print $field_value_upper?>;
										$(this).val(manipulate_date('SUBTRACT',dateto,1));
									}
								});
							}
						}

				<?php } ?>

				});
				<?php
			}}
	?>
	
});

function smart_submit(){
	get_values();
	$('#smartform').submit();
}

function clear_submit(){
	window.location = "<?php print $currenturl[0]?>?clearsmartf=true";
}

function saved_search_delete(){
	//$('#smartfid').val('<?php print $smartf_id; ?>');
	window.location = "<?php print $currenturl[0]?>?smartfid=<?php print $smartf_id; ?>&deletesmartf=true";
}

function smart_save(){
    ////console.log('smart_save');
	get_values();

	$filter_name = $('#smartfilters .filtername').val();

	if ($filter_name == '' || $filter_name == 'Enter your filter name'){
		$('#smartfilters .filtername').removeClass('field').addClass('field invalid');
		$("#smartfilters span.name-validation-label").html('Filter name is required.');
		return true;
	}

	$('#smartfiltername').val($filter_name);
	$('#smartform').submit();

}

//cancel save filter
function cancelsaveFilter(e){
  //console.log('cancelsaveFilter');
  e.preventDefault();
	var cancelFields = '<a href="#" id="smartsubmit" class="small-alt-button right apply" onclick="smart_submit();">Apply</a>' + '<a class="small-button right save" href="#">Save</a><span class="helper" id="savesearch-helper">You can save your search, so that you don&#146;t have to add filters each time you visit our course catalog. The saved filter will show up in the left side navigation under "Saved searches."<br><a class="hide-trigger" href="#helper">Hide</a><span class="helper-flag right"></span></span>';
	$('.button-group').html(cancelFields);
	$('.save').click(saveFilter);
}

// toggle smartfilters
function toggleSmartfilters(){
	var trigger = $('a.smartfilters-trigger');
	var smartfilters = $('#smartfilters');
	var basicsearch = $('.jumbo-search');

	if(trigger.hasClass('active')){
		trigger.removeClass('active');
		//smartfilters.slideUp(function(){
		//	basicsearch.slideDown();
		//});
		basicsearch.show();
		smartfilters.hide();

	    setTimeout(function() { $('#savesearch-helper').fadeIn(); }, 1000);
	    setTimeout(function() { $('.savesearch-helper').fadeOut();}, 1000);
	} else {
		trigger.addClass('active');
		//basicsearch.slideUp(function(){
		//	smartfilters.slideDown();
		//});
		basicsearch.show();
		smartfilters.show();

	};

};

var dateFromOptions = {
	defaultDate: new Date("1999,01,01"),
	changeMonth: true,
	changeYear: true,
	yearRange: '-20:+2',
	showOn: 'both',
	buttonImage: '/sites/all/themes/usgbc/lib/img/calendar_view_month.png',
	buttonImageOnly: true,
	dateFormat: "yy-mm-dd",
	onChangeMonthYear: function() {
		 setTimeout(function() {
		 $(".ui-datepicker .ui-state-active").removeClass("ui-state-active");
		 }, 0);
	}, 
}
var dateToOptions = {
		changeMonth: true,
		changeYear: true,
		yearRange: '-20:+2',
		showOn: 'both',
		buttonImage: '/sites/all/themes/usgbc/lib/img/calendar_view_month.png',
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		onChangeMonthYear: function() {
			 setTimeout(function() {
			 $(".ui-datepicker .ui-state-active").removeClass("ui-state-active");
			 }, 0);
		}, 
	}

function makeDateFromOptions(options){
	return function(defaultDate){
		options['defaultDate'] = defaultDate;
		return options;
	}
}
var makeDateFrom = makeDateFromOptions(dateToOptions);

var types = new Array();
var typeOptions = $('<div class="rule type"><select></select></div>');

//Manipulate the date to get proper search results and keep the between keyword intact
function manipulate_date(type,date,days){
	var modified_date = date;
	var dmy = date.split("-");        
	var custdate = new Date(
	    parseInt(dmy[0], 10),
	    parseInt(dmy[1], 10) - 1,
	    parseInt(dmy[2], 10)
	);
	if(type == 'ADD'){
		custdate.setDate(custdate.getDate() + days);
	    var curr_date = custdate.getDate();
		var curr_month = custdate.getMonth() + 1; //Months are zero based
		var curr_year = custdate.getFullYear();
		if(String(curr_date).length == 1) curr_date = "0" + curr_date;
		if(String(curr_month).length == 1) curr_month = "0" + curr_month;
		modified_date = curr_year + "-" + curr_month + "-" + curr_date;
	}else if(type == 'SUBTRACT'){
		custdate.setDate(custdate.getDate() - days);
	    var curr_date = custdate.getDate();
		var curr_month = custdate.getMonth() + 1; //Months are zero based
		var curr_year = custdate.getFullYear();
		if(String(curr_date).length == 1) curr_date = "0" + curr_date;
		if(String(curr_month).length == 1) curr_month = "0" + curr_month;
		modified_date = curr_year + "-" + curr_month + "-" + curr_date;
	}

	return modified_date;	
}
/*
 * Preconditions: smartfilter is initialized and is rendered on an html page 
 *
 * Function rips data from filters[], assembles + hands off a query to a form 
 */
function get_values(){
	var usedFilters = []; 		//array collects every filter that was previously used
	var query = '(';
	var lower_date = '';
	var upper_date = '';

	var mutableShortName = "";	//var shields shortname from being mutated inside the logic
								//exists to keep shortname available for string comparisons
								
	var addAND;					//var is a flag to decide between appending OR or AND in query
	
	for(var i=0; i< filters.length; i++){if(filters[i]!=null){
		var shortname = filters[i].shorts;
		var classname = '.' + shortname;
		shortname = filters[i].alias;
		$(classname).each(function() {
			mutableShortName = shortname;	//substitutes for shortname			

			//Separator is NOT prepended on the first pass of the logic loops
			//Separator is figured out on the second pass, when there is one item in usedFilters
			if(usedFilters.length >= 1){
				//check the usedFilters for duplicates, "smart" selection of separator
				for(var k = 0; k <= usedFilters.length; k++) {
					if (usedFilters[k] == shortname) { 	//if we find duplicate
						query = query + " OR  ";
						addAND = false;
						break;
					}
				}
				//if there was no duplicate above, this flag is true
				if(addAND){	
					query = query + " AND  ";
				}				
			}
			addAND = true; //always resets to true every pass
			
			if($(this).hasClass('datepicker')){
				$(this).parent().parent().find('.datepicker').each(function(){
					if($(this).hasClass('datefrom')) lower_date = $(this).val();
					else upper_date = $(this).val();
				});
				//WARNING: there is an array-split statement that is hard-coded to rely on the "' AND '" to be just that
				query = query + "(" + mutableShortName + " BETWEEN '" + manipulate_date('SUBTRACT',lower_date,1) + "' AND '" + manipulate_date('ADD',upper_date,1) + "') ";
			}else{
				var operator_classname = classname + '_operator';
				operator = $(this).parent().parent().parent().find(operator_classname).val();
				operator_type = "=";
				thevalue = $(this).val();
				if(operator == 'is') operator_type = " = ";
				//if(operator == 'is not') operator_type = " <> ";
				if(operator == 'contains'){
					 operator_type = " like ";
					 mutableShortName = 'LOWER(' + mutableShortName + ')';
					 thevalue = thevalue.toLowerCase(); 
					 thevalue = "%%" + thevalue + "%";
				}
				if (thevalue != '' && thevalue != "%%%")	{
					//query = query + shortname + operator_type + "'" + thevalue + "'  " + separator + "  ";	
					query = query + mutableShortName + operator_type + "'" + thevalue + "' ";
				}
				
			} // end else
			usedFilters.push(shortname); 	//every shortname is added to usedFilters every each{}
		}); // end each
	}} // end for loop
	
	query = query + ')';

	// (p OR p AND q) -> ((p OR p) AND (q))
	var queryArray = query.split('  AND  ');
	var splitterQuery = "";
	if(queryArray.length >= 2){
		for(var j = 0; j < queryArray.length; j++){
			splitterQuery = splitterQuery + "(" + queryArray[j] + ")" + "  AND  ";
		}
		splitterQuery = splitterQuery.substr(0, splitterQuery.length-6);
		$('#smartf').val(splitterQuery);
		return;
	}
	$('#smartf').val(query);
} // end get_values()

for(var i = 0; i < filters.length; i++){

	if(filters[i]!=null){ 
		if(filters[i].shorts!=null){
			types[i] = filters[i].shorts;
			typeOptions.find('select').append('<option value="' + filters[i].shorts + '">' + filters[i].full + '</option>');
		}
	}
};

$.fn.smartfilters = function(){
	var smartfilter = $(this);
	if(smartfilter.hasClass('preset-filters')){
  	 initializeFilter();
	} else {
  	 sampleFilters();
	}
	$('.filter .type select', smartfilter).live('change', changeFilterType);
	$('.filter .remove', smartfilter).live('click', removeFilter);
	$('.filter .add', smartfilter).live('click', addFilter);
	$('.save', smartfilter).click(saveFilter);

	// change filter type
	function changeFilterType(){
		var filter = $(this).parents('.filter');
		var type = $(this).val();
		
		filter.replaceWith(createFilter(type));
		initializeFilter();

	};

	function isBlacklisted( name ){
		iSize = blackListArray.length;
		for(i = 0; i < iSize ; i++){
			if(name == blackListArray[i])
				return true;
		}
		return false;
	}

	//function takes a filterNum and returns its options html
	function generateOptionsHTML(filterNum){
		var value = '';

		//if there are many selection entries to choose from, assemble and return a select tag filled with option tags
		if(filters[filterNum].value.options.length > 1){
			value = '<option value=""></option>';
			for(var i = 0; filters[filterNum].value.options[i] != null && i < filters[filterNum].value.options.length ; i++){
				var substr = filters[filterNum].value.options[i].split('_');
				var s_value = substr[0];
				var s_desc = substr[1];
				
				//run the filter option value against blacklisted data
				if( isBlacklisted(s_desc) ){
					//do nothing for this pass of the loop	
					continue;
				} else {
					if(s_desc == null){
						s_desc = s_value;
					}
					value = value + '<option value="' + s_value + '">' + s_desc + '</option>';
				}
			}
			return '<select class="' + filters[filterNum].shorts + '">' + value + '</select>';

		//if there is just one selection entry, return the one option tag with it selected
		} else {
			var substr = filters[filterNum].value.options[0].split('_');
			var s_value = substr[0];
			var s_desc = substr[1];
			if(s_desc == null)
				s_desc = s_value;
			var message = "View items with the field: " + s_desc;
			value =  '<option value="' + s_value + '">' + s_desc + '</option>';
			//return the message you want to give plus an invisible <select>
			hiddenSelect ='<div class="singleEntryMessage">' + message + '</div><div class="hiddenSelect"><select class="' + filters[filterNum].shorts +'">' + value + '</select></div>';
			return hiddenSelect;
		}
	}
	
	// create new filter
	function createFilter(type){

		var value = '';
		var conditional = '';
		var actions = '<ul class="actions"><li class="add"><a href="#"><span>Add another filter</span></a></li><li class="remove"><a href="#"><span>Remove this filter</span></a></li></ul>';
		//var actions = '';
		var filterNum = parseInt(getIndex(type));
		//console.log(filterNum);
		var shortid = filters[filterNum].shorts;

		// set conditionals
		if(filters[filterNum].value.type == 'date' || filters[filterNum].conditional == null){
			conditional = '';
		} else {
			for(var i = 0; i < filters[filterNum].conditional.length; i++){
				conditional = conditional + '<option value="' + filters[filterNum].conditional[i] + '">' + filters[filterNum].conditional[i] + '</option>';
			}
			//conditionalLogic = '<option value="' + filters[filterNum].conditional[0] + '">';
			conditional = '<select class='+shortid+'_operator>' + conditional + '</select>';
		};

		// value is text string
		if(type == 'location' || type == 'keyword' || filters[filterNum].value.type == 'text'){
			value = '<input type="text" class="field lg '+shortid+'" />';
		};

		// value is select
		if(type == 'leed' || type == 'format' || type == 'rating' || filters[filterNum].value.type == 'select'){
			value = generateOptionsHTML(filterNum);
		};

		// value is datepicker
		if(filters[filterNum].value.type == 'date'){
			value = '<div class="left date"><input class="datepicker field datefrom '+shortid+'" type="text" name="" value="From" /></div><div class="right date"><input class="datepicker field dateto" type="text" name="" value="To" /></div>';
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
			if(samples[i]!=null){
				var type = samples[i];
				$('#filter-set', smartfilter).append(createFilter(type));
			}
		};
		initializeFilter();
		var filterCount = $('.filter', smartfilter).length;		
		if((filterCount) == 1){
			$('.filter .actions .remove', smartfilter).hide();		
		}
	};

	// get type index
	function getIndex(type){
		for(var i = 0; i < types.length; i++){
			//console.log(types[i]);
			if(types[i] == type){ ;return i };
		};
	};

	// initialize new filter
	function initializeFilter(){

		var newFilter = $('.filter.new', smartfilter);

		newFilter.each(function(){
	  		$('select', this).uniform();

	  		$('.datepicker.datefrom', this).datepicker(dateFromOptions);
	  		$('.datepicker.dateto', this).datepicker(dateToOptions);

	  		$(this).removeClass('new');
	  		$('.hiddenSelect').hide();
		});
	};
};

// save filter
	function saveFilter(e){
		e.preventDefault();
		var saveFields = '<div class="right"><input name="filtername" class="left field lg filtername" type="text" value="' + '<?php echo ($smartf_name != '') ? $smartf_name : "Enter your filter name";?>' + '" /><a href="#" class="small-alt-button left save">Save</a><a href="#" id="cancelfilter" class="small-button cancelfilter left">Cancel</a><span class="name-validation-label invalid"></span></div>';
		$(this).parent('.button-group').html(saveFields);
		$val = '<?php echo $smartf_name;?>';
		if ($val == ''){
			$('input.filtername').autoclear();
		}else{
			$('input.filtername').val($val);
		}
		$('.save').click(smart_save);
		$('#cancelfilter').click(cancelsaveFilter);
	};
	
</script>
