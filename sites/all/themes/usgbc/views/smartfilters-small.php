<style type="text/css">
select {
	padding: 11px !important;
}
</style>
<?php

$current_display = $view->current_display;
$view_name = $view->name;
$current_smartf = 'smartf_'.$view_name.'_'.$current_display;

$allFields = $view->display[$current_display]->display_options['fields'];
dsm($allFields);

$existing_smartf = $_SESSION[$current_smartf];
$existing_smartf = str_replace('LOWER(node.title)) like \'%%%\'', "", $existing_smartf);

//the following code parses a smartfilter query string
//$existing_fields is created with what is parsed
if($existing_smartf){
	dsm($existing_smartf);
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
		//dsm($existing_fields);
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
	//dsm($ff->table_alias);

	//#1 init the data necessary to fill-out a filter javascript object
	$content_field 	= $ff->content_field;
	$ff_title 		= $content_field['widget']['label'];
	$ff_name 		= $content_field['field_name'];
	$ff_type 		= $content_field['type'];
	//$ff_table 		= $ff->table_alias;
	$ff_alias		= $ff->table_alias . "." . $ff->field;
	
	//#2 a base case for if the content field does not exist 
	// AND the current filter object corresponds to the title
	if(!$content_field && ($ff->real_field == 'title')){
		
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
		if($ff_title == 'Province'){ $ff_title = 'State';}
	}
	
	if($ff->real_field == 'field_credit_points_possible_upp_value'
		|| $ff->real_field == 'field_credit_points_possible_low_value'
		|| $ff->real_field == 'field_org_show_name_in_dir_value'
		|| $ff->real_field == 'field_per_fname_value'
		|| $ff->real_field == 'field_per_lname_value'
		|| $ff->real_field == 'field_related_chp_nid'
		|| $ff->real_field == 'field_related_org_nid'
		|| $ff->real_field == 'field_per_associations_value'
		|| $ff->real_field == 'field_per_leedcred_value'
		|| $ff->real_field == 'field_per_show_name_in_dir_value'
		|| $ff->real_field == 'field_crs_pvd_nid'){
		$ff_title = '';
		$ff_name = '';
		$ff_type = '';
		$ff_table = '';
		$ff_alias = '';
	}
	
	//#3 the (general) case for if the field title exists 
	// AND the field type does not have "file" in the name
	if($ff_title != '' && !inStr($ff_type,'file')){
		
		//#4 when the type of the field is a taxonomy, this means that the end-product filter will have a select dropdown
		// the array $allowed_values is created/filled-out here that corresponds to the select
		if(inStr($ff_type,'taxonomy')){
			$allowed_values = content_taxonomy_allowed_values($content_field, false);
		} else {
			$allowed_values = content_allowed_values($content_field, false);
		}
		
		//#5 run the case of select versus text on the allowed values that was created above
		if(empty($allowed_values)){
			$type = "text";
		} else {
			$type = "select";
		}
		?>
		{
		full: '<?php print $ff_title; ?>',
		shorts: '<?php print $ff_id; ?>',
		alias: '<?php print $ff_alias; ?>',

		<?php if($type == 'select'){ ?>
			conditional: 'is',
		<?php }else if ($type == 'text'){?>
			conditional: 'contains',
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

var initialFilters = [
<?php

if($existing_fields){
	$filterCount = sizeof($existing_fields);
	foreach($view->field as $ff_id=>$ff){
		$content_field 	= $ff->content_field;
		if(($content_field['widget']['label'] != '' || $ff->real_field == 'title' || $ff->real_field == 'city' || $ff->real_field == 'province' || $ff->real_field == 'country') && !inStr($content_field['type'],'file')){
			if($existing_fields[$ff_id])
			foreach($existing_fields[$ff_id] as $existing_field) print "'".$ff_id."',";
		}
	}
} else {
	$filterCount = 2;
	foreach($view->field as $ff_id=>$ff){
		$content_field 	= $ff->content_field;
		if(($content_field['widget']['label'] != '' || $ff->real_field == 'title'  || $ff->real_field == 'city' || $ff->real_field == 'province' || $ff->real_field == 'country') && !inStr($content_field['type'],'file')){
			print "'".$ff_id."',";
		}
	}
}
?>];

</script>
<script>
$(document).ready(function(){
	//$('#navCol').prepend('<a class="smartfilters-trigger" href="#">Smart filters</a>');
	$('#project-filter').smartfilters();
	$('a.smartfilters-trigger, #project-filter a').live('click', function(e){ e.preventDefault() });
	toggleSmartfilters();
	$('a.smartfilters-trigger').click(toggleSmartfilters);

	<?php
		if($existing_fields)
		foreach($existing_fields as $field_name=>$existing_field){
			foreach($existing_field as $fieldv){
				$field_value        = $fieldv['value'];
				$operator           = $fieldv['operator'];
				$field_value_lower  = $fieldv['value_lower']; // Lower date
				$field_value_upper  = $fieldv['value_upper']; // Upper date
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
	currUrl = "<?php print $_SERVER['REQUEST_URI'] ?>";
	if(currUrl.indexOf("clearsmartf=true") == -1){
		if(currUrl.indexOf("?") == -1){ //if no ? in url
			window.location = "<?php print $currenturl[0]?>?clearsmartf=true";
		} else { //if there is a ? in url
			window.location = "<?php print $_SERVER['REQUEST_URI'] ?>&clearsmartf=true";
		}
	} else {
		window.location = window.location;
	}
}

function saved_search_delete(){
	//$('#smartfid').val('<?php print $smartf_id; ?>');
	window.location = "<?php print $currenturl[0]?>?smartfid=<?php print $smartf_id; ?>&deletesmartf=true";
}

function smart_save(){
    ////console.log('smart_save');
	get_values();

	$filter_name = $('#project-filter .filtername').val();

	if ($filter_name == '' || $filter_name == 'Enter your filter name'){
		$('#project-filter .filtername').removeClass('field').addClass('field invalid');
		$("#project-filter span.name-validation-label").html('Filter name is required.');
		return true;
	}

	$('#smartfiltername').val($filter_name);
	$('#smartform').submit();

}

// toggle smartfilters
function toggleSmartfilters(){
	var trigger = $('a.smartfilters-trigger');
	var smartfilters = $('#project-filter');
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

var dateOptions = {
		changeMonth: true,
		changeYear: true,
		yearRange: '-10:+5',
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

var types = new Array();

/* variable will hold <option> tags of all fields associated with the current view
   variable is initialized to an empty div.select */
var typeOptions = $('<div class="rule type"><select></select></div>');

/* variable corresponds to the number of filters that all smallsmartfilters will dispaly upon their creation */
var filterCount = <?php echo $filterCount;?>;

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

/**
 * Function rips data from filters[], assembles + hands off a query to a form 
 */
function get_values(){
	usedFilters = []; 		//array collects every filter that was previously used
	query = '(';
	lower_date = '';
	upper_date = '';

	mutableShortName = "";	//var shields shortname from being mutated inside the logic
								//exists to keep shortname available for string comparisons
								
	var addAND;					//var is a flag to decide between appending OR or AND in query
	

	for(var i=0; i< filters.length; i++){if(filters[i]!=null){
		shortname = filters[i].shorts;
		classname = '.' + shortname;
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
				}			//if there was no duplicate above, this flag is true
				if(addAND){	
					query = query + " AND  ";
				}				
			}
			addAND = true; //always resets to true every pass
			if($(classname).val() != ''){
				var operator_classname = classname + '_operator';
				operator = $(this).parent().parent().find('.rule.conditional.' + operator_classname).attr('cval');
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
				//if (thevalue != '' && thevalue != "%%%")	{
					//query = query + shortname + operator_type + "'" + thevalue + "'  " + separator + "  ";	
					query = query + mutableShortName + operator_type + "'" + thevalue + "' ";
				//}
				
				usedFilters.push(shortname); 	//every shortname is added to usedFilters every each{}
			} else {
				query = query + 'LOWER(' +shortname + ") like " + "'%%" + $(this).val() + "%' ";
			}
		usedFilters.push(shortname); 	//every shortname is added to usedFilters every each{}

	}); // end each
	}} // end for loop
	
	query = query + ')';

	// (p OR p AND q) -> ((p OR p) AND (q))
	queryArray = query.split('  AND  ');
	splitterQuery = "";
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

//loop over filters[], detect and remove single-entry select fields
//these fields are disabled in the minifilter
for(var i = 0; i < filters.length; i++){
	filterOptions = filters[i].value.options;
	if(( filterOptions && filterOptions.length == 1 && filters[i].value.type == 'select') 
			|| filters[i].alias.charAt(0) == "."
			|| filters[i].full.toLowerCase() == 'date'){
		//single element removal
		var rest = filters.slice(i+1);
		filters.length = i;
		Array.prototype.push.apply(filters, rest);
	}
}

//loop over filters[] to create the types[] and typeOptions[]
for(var i = 0; i < filters.length; i++){
	if(filters[i]!=null ){ 
		if(filters[i].shorts!=null){
			types[i] = filters[i].shorts;
			typeOptions.find('select').append('<option value="' + filters[i].shorts + '">' + filters[i].full + '</option>');
		}
	}
}

$.fn.smartfilters = function(){
	maxFilterCount = types.length;
	var smartfilter = $(this);	
	if(smartfilter.hasClass('preset-filters')){
  	 initializeFilter();
	} else {
  	 initialFilters();
	}
	$('.filter .type select', smartfilter).live('change', changeFilterType);
	$('#project-filter .add').live('click', function(){
		add_next_filter();
		currFilterCount = $('.filter', smartfilter).length;
		if(currFilterCount == maxFilterCount){
			$(this).attr('style', 'display:none');
		}
	});

	// change filter type
	function changeFilterType(){
		var filter = $(this).parents('.filter');
		var type = $(this).val();

		filter.replaceWith(createFilter(type));
		initializeFilter();
	};

	//function takes a filterNum and returns its options html
	function generateOptionsHTML(filterNum){
		value = '';

		//if there are many selection entries to choose from, assemble and return a select tag filled with option tags
		if(filters[filterNum].value.options.length > 1){
			value = '<option selected="true" style="display:none" value="">' + filters[filterNum].full + ' options</option>';
			for(var i = 0; filters[filterNum].value.options[i] != null && i < filters[filterNum].value.options.length ; i++){
				var substr = filters[filterNum].value.options[i].split('_');
				var s_value = substr[0];
				var s_desc = substr[1];
				if(s_desc == null){
					s_desc = s_value;
				}
				value = value + '<option value="' + s_value + '">' + s_desc + '</option>';
			}
			return '<select class="' + filters[filterNum].shorts + '">' + value + '</select>';

		//if there is just one selection entry, return the single option tag with it selected
		} else {
			var substr = filters[filterNum].value.options[0].split('_');
			var s_value = substr[0];
			var s_desc = substr[1];
			if(s_desc == null){
				s_desc = s_value;
			}
			var message = "View items with the field: " + s_desc;
			value =  '<option value="' + s_value + '">' + s_desc + '</option>';
			//return the message you want to give plus an invisible <select>
			hiddenSelect ='<div class="singleEntryMessage">' + message + '</div><div class="hiddenSelect"><select class="' + filters[filterNum].shorts +'">' + value + '</select></div>';
			return hiddenSelect;
		}
	}
	
	// create new filter
	function createFilter(type){
		filterNum = parseInt(getIndex(type));
		
		//console.log(filterNum);
		var shortid = filters[filterNum].shorts;
		var value = '';

		// value is text string
		if(filters[filterNum].value.type == 'text'){
			value += '<span>' + filters[filterNum].full + '</span>';
			value += '<div class="rule value">';
			value += '<input type="text" class="field keyword '+shortid+'" /></div>';
		};

		// value is select
		if(filters[filterNum].value.type == 'select'){
			value = generateOptionsHTML(filterNum);
		};

		var type_menu = $(typeOptions).clone();
		$('select',type_menu).val(type);

		var singleFilterString = '';
		singleFilterString += '<div class="filter new">';
		//singleFilterString += '<p></p>';
		//singleFilterString +=   '<span>' + filters[filterNum].full + '</span>';
		singleFilterString += 	value;
		singleFilterString += 	'<div class="rule conditional ' + shortid + '_operator" cval="' + filters[filterNum].conditional + '"></div>';
		singleFilterString += '<p></p>';
		singleFilterString += 	'<div style="display:none" class="rule type"></div>';
		//singleFilterString += actions;
		singleFilterString += '</div>';
			
		var newFilter = $(singleFilterString);
		//var newFilter = $(newFilterString);
		
		newFilter.find('.rule.type').append(type_menu);
		return newFilter;
	};

	// initial filters
	function initialFilters(){		
		$('#filter-set-small .filter', smartfilter).remove();
		possibleLength = types.length;
		if(filterCount > possibleLength){
			filterCount = possibleLength;
		}
		for(i = 0 ; i+1 <= filterCount ; i++){
			$('#filter-set-small', smartfilter).append(createFilter(types[i]));
		};
		initializeFilter();
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
  			//$('.datepicker', this).datepicker(dateOptions);
  			$(this).removeClass('new');
  			$('.hiddenSelect').hide();
		});
	};

	//Function that is called by a smartfilters-small-ui.php onclick event.
	//Function detects how many filters are displayed, and displays the next one if it can
	function add_next_filter(){
		//currFileCount is inherently the next index due to 0th-based array indexing 	
		currFilterCount = $('.filter', smartfilter).length;
		filter = $('#filter-set-small', smartfilter);
		// compare the next index to the length of the types array, 
		// there shall be only one filter per one entry in the types array
		if( currFilterCount < types.length){
			//display the next filter
			filter.append(createFilter(types[currFilterCount]));
			initializeFilter();
			filterCount += 1;
		}
	}
};

</script>