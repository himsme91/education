<?php
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
<?php 
//dsm($exposed);
drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');

drupal_add_js(drupal_get_path('theme', 'usgbc') .'/lib/js/jquery.pagingselection.js');

drupal_add_css(drupal_get_path('theme', 'usgbc') .'/lib/css/section/store.css');

$items_per_page_override = ($_GET['pagesize'] > 0) ? $_GET['pagesize'] : 30;

$title = ($_GET['title'] != '') ? $_GET['title'] : 'Search the store';

$title_sort = ($_GET['title_sort'] == 'unsorted' || $_GET['title_sort'] == '') ? $_GET['title_sort'] : 'ASC';

$created_sort = ($_GET['created_sort'] == 'unsorted' || $_GET['created_sort'] == '') ? $_GET['created_sort'] : 'ASC';

$currenturl = explode("?", $_SERVER['REQUEST_URI']);
?>

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
    
     <div id="events-search" class="jumbo-search">
                    <div class="jumbo-search-container">
                      <form action="<?php echo $currenturl[0];?>" method="get">
                        <input type="text" class="jumbo-search-field default" name="title" value="<?php echo $title ; ?>" defaultvalue="Search the store">
              	        <input type="submit" class="jumbo-search-button" name="" value="Search" src="/themes/usgbc/lib/img/search-icon-button.gif">            
            	        </form>	                    	                    	    
                    </div>
                </div>
                
  <!--  <div class="view-filters">
      <?php print $exposed; ?>
    </div> -->
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>
<div class="search-report aside" >
<span>
    <?php echo '<strong>'.number_format($view->total_rows).' </strong>';?>
<?php echo (intval($view->total_rows) == 1) ? ' result' : ' results'?>
<?php if ($title != 'Search the store') : ?>
<?php print ' for ';?>
<strong>
<?php print $title;?>
</strong>
<?php endif; ?>
 in
<strong><?php 
$page_view = views_get_page_view(); // for a page display
$arg0 = $page_view->view->args[0];
$arg1 = $page_view->view->args[1];
$arg2 = $page_view->view->args[2];

if(!empty($arg2)){
	print_r(str_replace('-', ' ', ucwords($arg2)));
}elseif(!empty($arg1)){
	print_r(str_replace('-', ' ', ucwords($arg1)));
}elseif(!empty($arg0)){
	print_r(str_replace('-', ' ', ucwords($arg0)));
}else{
	print_r("All.");
}


/*
if (!empty($arg0)){
	if(!empty($arg1)){
		if(!empty($arg2)){
			print_r(str_replace('-', ' ', ucwords($arg2)));
		}else{
			print_r(str_replace('-', ' ', ucwords($arg1)));
		}
	}else {
		print_r(str_replace('-', ' ', ucwords($args0)));
	}
}
else {
    print_r("All.");
}*/

?></strong>
</span>
</div>

 <div class="ag-header">
  
   <div class="ag-sort">
	<p>Sort</p>
    <div id="items-sort-selector" class="ag-sort-container">
    	<select>
			<option value="title_sort=unsorted&created_sort=ASC"<?php echo ($created_sort == 'ASC') ? ' selected="selected"' : ''; ?>>Newest</option>
			<option value="title_sort=ASC&created_sort=unsorted"<?php echo ($title_sort == 'ASC') ? ' selected="selected"' : ''; ?>>A-Z</option>
		</select>
	</div>
</div> 
  
  
  <div class="ag-sort">
<p>Results</p>
<div id="pagesize-selector" class="ag-sort-container">
<select>
<option value="30"<?php echo ($items_per_page_override == 30) ? ' selected="selected"' : ''; ?>>30</option>
<option value="60"<?php echo ($items_per_page_override == 60) ? ' selected="selected"' : ''; ?>>60</option>
<option value="120"<?php echo ($items_per_page_override == 120) ? ' selected="selected"' : ''; ?>>120</option>
</select>
</div>
</div>
  
    <?php if ($pager): ?>
      <?php print $pager; ?>
  <?php endif; ?>
  </div>

<div class="clear-block"></div>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div> <?php /* class view */ ?>

