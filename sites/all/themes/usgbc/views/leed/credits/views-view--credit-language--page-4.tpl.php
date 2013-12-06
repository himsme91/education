<?php
include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-small.php';
drupal_add_css(drupal_get_path('theme', 'usgbc') .'/lib/css/liapplicabilitybox.css');
drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');

$date_sort = ($_GET['field_li_date_value_sort'] == 'unsorted' || $_GET['field_li_date_value_sort'] == '') ? $_GET['field_li_date_value_sort'] : 'DESC';
$credit_category_sort = ($_GET['credit_category_weight_sort'] == 'unsorted' || $_GET['credit_category_weight_sort'] == '') ? $_GET['credit_category_weight_sort'] : 'ASC';
$id_sort = ($_GET['field_li_id_value_sort'] == 'unsorted' || $_GET['field_li_id_value_sort'] == '') ? $_GET['field_li_id_value_sort'] : 'DESC';
$type_sort = ($_GET['entry_type_weight_sort'] == 'unsorted' || $_GET['entry_type_weight_sort'] == '') ? $_GET['entry_type_weight_sort'] : 'DESC';

if (arg(0) == 'node' && is_numeric(arg(1))) {
	$nodeid = arg(1);
}

// $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>

<script>

$(document).ready(function(){
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
				itemPrimaryCredit, itemPrimaryRatingSystem, URL, 'li');
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
	$('.sh-trigger').click(function(e){
		e.preventDefault();
	});
	
	$('.blocklink').live('click',function(){
		$(this).find('.sh-content').slideToggle(600);
		$(this).find('.criteria-head').toggleClass("expanded");
		$(this).toggleClass('blocklink-selected');	
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

function generateMailToBody(entryType, date, id, prereqLine, primaryRatingLine, URL, postType){
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
	var DD = dateString.substr(9,1);
	var MM = dateString.substr(6,1);
	var YYYY = dateString.substr(0,4);
	return MM + '/'	+ DD + '/' + YYYY;
}

</script>

<style>
.highlight{
background-color: #FFFF00;
}
.blocklink:hover{
	cursor:pointer;
    background-color: #F1F6F7;
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

.note{
	font-size:.8em;
}

</style>



<div class="<?php print $classes; ?>">
	  <?php if ($admin_links): ?>
	    <div class="views-admin-links views-hide">
	      <?php print $admin_links; ?>
	    </div>
	  <?php endif; ?>
	
	<div class="threeCol" id="content">
		<div id="navCol">
			<?php include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-small-ui.php'; ?>
		</div>
		<div id="mainCol" style="margin-right:10px">
			<div class="search-report aside">
				<span><?php echo '<strong>'.number_format($view->total_rows).' </strong>';?> <?php echo (intval($view->total_rows) == 1) ? ' result match' : ' results match'?>
				</span>
			</div>
			<div class="ag-header">
				<div class="ag-sort">
					<p>Sort</p>
					<div id="items-sort-selector" class="ag-sort-container">
						<select>
							<option value="entry_type_weight_sort=unsorted&field_li_id_value_sort=unsorted&credit_category_weight_sort=unsorted&field_li_date_value_sort=DESC"
							<?php echo ($date_sort == 'DESC') ? ' selected="selected"' : ''; ?>>Date</option>
							<option	value="entry_type_weight_sort=unsorted&field_li_id_value_sort=unsorted&credit_category_weight_sort=ASC&field_li_date_value_sort=unsorted"
							<?php echo ($credit_category_sort == 'ASC') ? ' selected="selected"' : ''; ?>>Credit Category</option>
							<!-- <option value="entry_type_weight_sort=unsorted&field_li_id_value_sort=DESC&credit_category_weight_sort=unsorted&field_li_date_value_sort=unsorted"
							<?php echo ($id_sort == 'DESC') ? ' selected="selected"' : ''; ?>>ID</option>
					 		-->	
					 		<option value="entry_type_weight_sort=DESC&field_li_id_value_sort=unsorted&credit_category_weight_sort=unsorted&field_li_date_value_sort=unsorted"
							<?php echo ($type_sort == 'DESC') ? ' selected="selected"' : ''; ?>>Entry type</option>							
						</select>
					</div>
				</div>
		
				<div class="ag-sort">
					<input type="checkbox" name="expand_all" value="expand_all" id="expand_all"/> Expand all
				</div>
				<div class="right">
  					<a class="small-alt-button" href="/linked-leed-interpretations-download/<?php echo $nodeid; ?>">DOWNLOAD</a>
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
		  	</div>
		</div>
		<div class="sideCol">
			<div class="section">
			<p><em class="no-match" style="font-size:10px;">The LIs listed here do NOT include every applicable LI. Please refer to the link to the LI database, below, for comprehensive listings.</em></p>
			<h6>Interpretations &amp; Addenda Database</h6>
			<p class="note">LEED Interpretations are precedent-setting rulings reviewed by USGBC on Formal Inquiries submitted by LEED project teams that can be applied to multiple projects. Addenda are permanent changes and improvements to LEED 2009 resources, including rating systems and reference guides. <a href="/leed-interpretations" class="small-link more-link" target="_blank">Search the database</a></p>
			</div>
		</div>
		
	</div>	  	
	
	  <?php if ($pager): ?>
	    <?php print $pager; ?>
	  <?php endif; ?>
	</div>

</div> <?php /* class view */ ?>