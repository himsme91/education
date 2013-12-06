<?php 
include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-li.php';
drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');
drupal_add_css(drupal_get_path('theme', 'usgbc') .'/lib/css/liapplicabilitybox.css');

$date_sort = ($_GET['field_li_date_value_sort'] == 'unsorted' || $_GET['field_li_date_value_sort'] == '') ? $_GET['field_li_date_value_sort'] : 'DESC';
$credit_category_sort = ($_GET['credit_category_weight_sort'] == 'unsorted' || $_GET['credit_category_weight_sort'] == '') ? $_GET['credit_category_weight_sort'] : 'ASC';
$id_sort = ($_GET['field_li_id_value_sort'] == 'unsorted' || $_GET['field_li_id_value_sort'] == '') ? $_GET['field_li_id_value_sort'] : 'DESC';
$type_sort = ($_GET['entry_type_weight_sort'] == 'unsorted' || $_GET['entry_type_weight_sort'] == '') ? $_GET['entry_type_weight_sort'] : 'DESC';

$default_title = "Enter keyword";
$title = ($_GET['keys'] != '') ? $_GET['keys'] : 'Enter keyword';
$currenturl = explode("?", $_SERVER['REQUEST_URI']);
drupal_add_js('sites/all/themes/usgbc/lib/node/zeroClipboard/zclip.js');
?>


<script>
/**
 * Function takes string parameters and returns a formatted email body.
 * The params coming in from $node for data-credit and data-rating-sys 
 * are not able to be sanitized of breaks/newlines.
 */
function generateMailToBody(entryType, date, id, prereqLine, primaryRatingLine, URL){
	//Assemble formatted email with parameters
	return  'Made on: ' + date + ' | ' + entryType 
	+ '\r\n' + '\r\n' + 'Prerequisite/Credit: ' + prereqLine 
	+ '\r\n' + 'Primary Rating System: ' + primaryRatingLine 
	+ '\r\n' + '\r\n' + 'Click here to view the full entry: ' + URL;
}

/**
 * Function modifies a date string (YYYY/MM/DDT:XX:XX:XX) -> (MM/DD/YYYY)
 * Reminder: JS strings are immutable
 */
function formatDate(dateString){
	if(dateString==null){
		return "Date not found";
	} 

	//"2010-04-14T00:00:00"
	
	var YYYY = dateString.substr(0,4);
	var MM = dateString.substr(5,2);
	var DD = dateString.substr(8,2);
		
	return MM + '/'	+ DD + '/' + YYYY;
}
		
$(document).ready(function(){
	/*
	// just add class="autoclear" to your input
	$("#edit-title").click(function() {
		if($(this).val() == $(this).attr('defaultValue')){ 
			$(this).val("");
		}
	});*/

	//copy to clipboard function
	$('.allow-copy').zclip({
		path:'/sites/all/themes/usgbc/lib/node/zeroClipboard/ZeroClipboard.swf',
		copy:$(this).parent().find('.content-copy').text()
	});
	// The link with ID "copy-description" will copy
	// the text of the paragraph with ID "description"
	
	
	// if the user enters nothing, this will restore default text
	$("#edit-title").blur(function() {
		if($(this).val() == ""){ 
			$(this).val("<?php echo $default_title;?>");
			$(this).removeAttr("autoClearFalse");
			$(this).autoclear();
		}
	});
	
	
	$("#edit-title").change(function() {
		if($(this).val() == "<?php echo $default_title;?>"){
			//it is the default, let it autoclear 
			if($(this).attr("autoClearFalse")){
				$(this).removeAttr("autoClearFalse");
			}
		} else {
			//it is not the default, do not let it autoclear
			$(this).attr("autoClearFalse", 1);
		}
	});
	

	$('a.share').click(function(e){
		//preconditions
		e.preventDefault();
		e.stopPropagation();

		//pull in necessary data
		URL = $(this).data('url');
		var itemEntryType = $(this).data('entry-type');
		var itemDate = $(this).data('date');
		var formattedItemDate = itemDate; 
		var itemId = $(this).data('id');
		var itemPrimaryCredit = $(this).data('credit');
		var itemPrimaryRatingSystem = $(this).data('rating-sys');

		//compose email body
		var formattedBody = generateMailToBody(itemEntryType, formattedItemDate, itemId, 
				itemPrimaryCredit, itemPrimaryRatingSystem, URL);
		var mailToLink = 'mailto:?subject=' + itemEntryType + ' ( ID: ' + itemId + ' )' + '&body=' + encodeURIComponent(formattedBody);	

		//set the mail link
		window.location.href = mailToLink;

	});
	
	$('a.credit-link').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		URL = $(this).data('url');
		window.location.href = URL;
	});
	
		$(".sh-content").hide();

	
		$('.blocklink:not(.blocklink a)').live('mousedown',function(evt){

			evt = evt || window.event;
		    var button = evt.which || evt.button;
		    if(button == 1){
		    	
			var collapse = true;

			$('.blocklink').live('mousemove',function(e){
				e.stopPropagation();
				collapse = false;
			});

			//disable expand/collapse for anchor tags
			$('.blocklink a').live('mouseup',function(e){
				e.stopPropagation();
				//e.preventDefault();
			});
			
			$('.blocklink').live('mouseup',function(){
				if(collapse == true){
					$(this).find('.sh-content').slideToggle(600);
					$(this).find('.criteria-head').toggleClass("expanded");
					$(this).toggleClass('blocklink-selected');	
				}
			});
		    }
		//$(this).find('.sh-content').slideToggle(600);
		//$(this).find('.criteria-head').toggleClass("expanded");
		//$(this).toggleClass('blocklink-selected');	
	});

	$("input[type='checkbox']").click(function(e){
	    if($(this).is(":checked")){
			var blocksrc = $('.block-link-src');
			var parentDiv = blocksrc.parents('.criteria').find('.sh-content');
			parentDiv.slideDown(600);
			blocksrc.parents('.criteria-head').addClass("expanded")
			var summaryliDiv = blocksrc.parents('.criteria').find('.summary');
			summaryliDiv.hide();
			var summaryadDiv = blocksrc.parents('.criteria').find('.addenda');
			summaryadDiv.show();
			blocksrc.parents('.criteria').parents('.blocklink').removeClass('blocklink-selected');
	    }else{
			var blocksrc = $('.block-link-src');
			var parentDiv = blocksrc.parents('.criteria').find('.sh-content');
			parentDiv.slideUp(600);
			blocksrc.parents('.criteria-head').toggleClass("expanded")
			var summaryliDiv = blocksrc.parents('.criteria').find('.summary');
			summaryliDiv.show();
			blocksrc.parents('.criteria').parents('.blocklink').removeClass('blocklink-selected');
	    }
	});

});

</script>
<style>
.highlight{
background-color: #FFFF00;
}
.blocklink:hover{
	cursor:pointer;
    background-color: #F1F6F7;
}

.inquiry, .ruling{
	width:150px;
	display: inline-block;
}

.related-addenda{
	width:450px;
	display: inline-block;
}

.allow-copy{
		background-image: url(/sites/all/themes/usgbc/lib/img/clipboard.png);
		background-repeat: no-repeat;
		background-size: 25px 25px;
		background-position: right;
		float:left;
		width:25px;
		height:25px;
}

.inquiry h3, .ruling h3, .related-addenda h3{
	float:left;
}
	
.blocklink-selected{
    background-color: #F1F6F7;	
	border:1px solid #ddd;
	border-top:1px solid #ddd !important;
}

.blocklink-selected .criteria-head p.summary{
	display:none;
}
.blocklink-selected .criteria-head p.date{
	display:block;
	color:black;
}

.credit-lib-navli {
    background-color: #F1F6F7; /* fallback color */
    background-image: -moz-linear-gradient(100% 100% 90deg, #E7F0F2, #F1F6F7);
    background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#F1F6F7), to(#E7F0F2));
    border: 1px solid #C0D1D5;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .1), 0 1px 0 white inset;
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .1), 0 1px 0 white inset;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .1), 0 1px 0 white inset;
    -moz-border-radius: 4px;
    border-radius: 4px;
    margin-bottom: 15px;
    font-family: "proxima-nova-1", "proxima-nova-2", "Helvetica Neue", Arial;
    clear: both;
    padding: 6px 0 6px 14px;
    *zoom: 1;

}

.credit-lib-navli:after {
    content: ".";
    display: block;
    height: 0;
    clear: both;
    visibility: hidden;
}

.credit-lib-navli h4 {
    float: left;
    width: 164px;
    text-transform: uppercase;
    font-size: 18px;
    line-height: 1.1;
    margin-top: 11px;
}

.credit-lib-navli .drop-menu {
    position: relative;
    float: left;
    width: 504px;
}

.credit-lib-navli .drop-menu .placeholder {
    display: block;
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/nav-1.png') no-repeat;
    height: 31px;
    font-size: 16px;
    color: #59656A;
    padding-top: 10px;
    padding-left: 20px;
}

.credit-lib-navli .li-version {
    margin-left: -10px;
    width: 280px;
}

.credit-lib-navli .li-version .placeholder {
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/nav-2.png') no-repeat;
/ / width : 301 px;
    padding-left: 34px;
}

.credit-lib-navli .drop-menu .placeholder:active,
.credit-lib-navli .open .placeholder {
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/nav-1-active.png') no-repeat;
    color: #EBEEEF;
    text-shadow: 0 1px 2px rgba(0, 0, 0, .4);
}

.credit-lib-navli .li-version .placeholder:active,
.credit-lib-navli .li-version.open .placeholder {
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/nav-2-active.png') no-repeat;
}

.credit-lib-navli .drop-menu .drop-panel,
.credit-lib-navli .drop-menu .sub-drop-panel {
    display: none;
    position: absolute;
    padding: 15px;
    top: 52px;
    left: 0;
    right: 17px;
    background: #F6F6F6;
    border: 1px solid #CCC;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .15), 0 1px 0 white inset;
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .15), 0 1px 0 white inset;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .15), 0 1px 0 white inset;
    -moz-border-radius: 3px;
    border-radius: 3px;
    z-index: 3;
    overflow: hidden;
}

.credit-lib-navli .open .drop-panel,
.credit-lib-navli .open .open .sub-drop-panel {
    display: block;
}

.credit-lib-navli .li-version .drop-panel {
    right: -5px;
}

.credit-lib-navli .drop-menu .drop-panel li {
    list-style: none;
    margin: 0
}

.credit-lib-navli .drop-menu .drop-panel li a {
    color: #444;
    display: block;
    padding: 8px 12px;
    text-shadow: 0 1px 0 white;
}

.credit-lib-navli .drop-menu .drop-panel li a:hover,
.credit-lib-navli .drop-menu .drop-panel li.active a {
    background: #EDEDED;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .2) inset;
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .2) inset;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .2) inset, 0 1px 0 white;
    -moz-border-radius: 3px;
    border-radius: 3px;

    -webkit-transition: all .05s ease-in-out;
    -moz-transition: all .05s ease-in-out;
    -o-transition: all .05s ease-in-out;
    transition: all .05s ease-in-out;
}

.credit-lib-navli .drop-menu .drop-panel li.active a {
    background-color: #DDD;
}

.credit-lib-navli .drop-menu .drop-panel .sub-drop-panel {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 90%;
    left: -400px;
    /* left: 0px; right: 0; */

    margin-bottom: 0 !important;
    box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    border: 0;

    /* display: none; */
}

.credit-lib-navli .drop-panel .panel-nav {
    position: absolute;
    bottom: 15px;
    left: 50%;
    margin-left: -10px;
    margin-bottom: 0;
}

.credit-lib-navli .drop-panel .panel-nav li {
    float: left;
    margin-right: 6px;
    width: 6px;
    height: 6px;
    padding: 0 !important;
    background: none;
}

.credit-lib-navli .drop-panel .panel-nav li a {
    display: block;
    text-indent: -9999px;
    width: 6px;
    height: 6px;
    -moz-border-radius: 6px;
    border-radius: 6px;
    background: #ccc;
    padding: 0;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .2) inset 0 1px 0 white;
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .2) inset 0 1px 0 white;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .2) inset, 0 1px 0 white;
}

.credit-lib-navli .drop-panel .panel-nav li.active a {
    background: #555;
    border: 0;
}

.drop-menu .drop-panel,
.drop-menu .sub-drop-panel {
    -webkit-transition: all .5s ease-in-out;
    -moz-transition: all .5s ease-in-out;
    -o-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
}
</style>

	<div class="<?php print $classes; ?>">
	  <?php if ($admin_links): ?>
	    <div class="views-admin-links views-hide">
	      <?php print $admin_links; ?>
	    </div>
	  <?php endif; ?>
		  <?php if ($header): ?>
	    <div class="view-header">
	      <?php print $header; ?>
	    </div>
	  <?php endif; ?>
	<?php if ($exposed): ?>
	  <?php print $exposed; ?>
	 
	    <div id="events-search" class="jumbo-search">
	                    <div class="jumbo-search-container">
	                       <form action="<?php echo $currenturl[0];?>" method="get">  
	                       <?php
	                       echo '<input ';
	                         if($title != $default_title){ 
							   echo 'autoClearFalse="1"';
	                         }
							echo ' defaultValue="Enter keyword" id="edit-title" type="text" class="jumbo-search-field default" name="keys" value="'. $title. '">';
	                       ?>
	                          <input type="submit" class="jumbo-search-button" name="" value="Search" src="/themes/usgbc/lib/img/search-icon-button.gif">   
	                      </form> 
	                    </div>
	                </div>
	<?php include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-ui.php'; ?>  
	<?php endif;?>
	<div class="search-report aside">
		<span><?php echo '<strong>'.number_format($view->total_rows).' </strong>';?> <?php echo (intval($view->total_rows) == 1) ? ' result match' : ' results match'?>
		</span>
	</div>
	<div class="ag-header">
		<div class="ag-sort">
			<p>Sort</p>
			<div id="items-sort-selector" class="ag-sort-container">
				<select>
					<option
						value="entry_type_weight_sort=unsorted&field_li_id_value_sort=unsorted&credit_category_weight_sort=unsorted&field_li_date_value_sort=DESC"
						<?php echo ($date_sort == 'DESC') ? ' selected="selected"' : ''; ?>>Date</option>
					<option
						value="entry_type_weight_sort=unsorted&field_li_id_value_sort=unsorted&credit_category_weight_sort=ASC&field_li_date_value_sort=unsorted"
						<?php echo ($credit_category_sort == 'ASC') ? ' selected="selected"' : ''; ?>>Credit Category</option>
				<!-- <option
						value="entry_type_weight_sort=unsorted&field_li_id_value_sort=DESC&credit_category_weight_sort=unsorted&field_li_date_value_sort=unsorted"
						<?php echo ($id_sort == 'DESC') ? ' selected="selected"' : ''; ?>>ID</option>
				 -->	
				 	<option
						value="entry_type_weight_sort=DESC&field_li_id_value_sort=unsorted&credit_category_weight_sort=unsorted&field_li_date_value_sort=unsorted"
						<?php echo ($type_sort == 'DESC') ? ' selected="selected"' : ''; ?>>Entry type</option>							
				</select>
			</div>
		</div>
		<div class="ag-sort">
			<input type="checkbox" name="expand_all" value="expand_all" id="expand_all"/> Expand all
		</div>
		<div class="right">
  			<a class="small-alt-button" href="/leed-interpretations-download">DOWNLOAD</a>
  		</div>

	</div>
	<div class="clear-block"></div>
	<div id="article-list-view">
	  <?php if ($rows): ?>
		<ul class="linelist ra-list">
	      <?php print $rows; ?>
		</ul>
	  <?php elseif ($empty): ?>
	    <div class="view-empty">
	      <?php print $empty; ?>
	    </div>
	  <?php endif; ?>
	
	  <?php if ($pager): ?>
	    <?php print $pager; ?>
	  <?php endif; ?>
	</div>

</div> <?php /* class view */ ?>