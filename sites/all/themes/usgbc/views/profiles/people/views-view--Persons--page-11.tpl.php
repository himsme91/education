<style type="text/css">
.views-exposed-widget { display:none;}
div#mainCol h3, div#mainCol h4 {
    padding-top: 0;
}
</style>


<?php 
include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters.php';
drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');
drupal_add_js(drupal_get_path('theme', 'usgbc') .'/lib/js/jquery.pagingselection.js');

$items_per_page_override = ($_GET['pagesize'] > 0) ? $_GET['pagesize'] : 30;

$title = ($_GET['keys'] != '') ? $_GET['keys'] : 'Search people';

$field_per_fname_value_sort = ($_GET['field_per_fname_value_sort'] == 'unsorted' || $_GET['field_per_fname_value_sort'] == '') ? $_GET['field_per_fname_value_sort'] : 'ASC';
$created_sort 				= ($_GET['created_sort'] == 'unsorted' || $_GET['created_sort'] == '') ? $_GET['created_sort'] : 'DESC';
$has_prof_sort				= ($_GET['has_prof_sort'] == 'unsorted' || $_GET['has_prof_sort'] == '') ? $_GET['has_prof_sort'] : 'DESC';

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
   <?php print $exposed; ?>
  <div id="events-search" class="jumbo-search">
                    <div class="jumbo-search-container">
                      <form action="<?php echo $currenturl[0];?>" method="get">
                        <input type="text" class="jumbo-search-field default" name="keys" value="<?php echo $title ; ?>" defaultvalue="Search people">
              	        <input type="submit" class="jumbo-search-button" name="" value="Search" src="/themes/usgbc/lib/img/search-icon-button.gif">            
            	        </form>	                    	                    	    
                    </div>
                </div>
     
<?php include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-ui.php'; ?>  
   
  
  <!--  <div class="view-filters">
      <?php print $exposed; ?>
    </div> -->
  <?php endif; ?>


  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>
<div class="search-report aside hidden" >
<span>
    <?php echo '<strong>'.number_format($view->total_rows).' </strong>';?>
<?php echo (intval($view->total_rows) == 1) ? ' result' : ' results'?>
<?php if ($title != 'Search people') : ?>
<?php print ' for ';?>
<strong>
<?php print $title;?>
</strong>
<?php endif; ?>
 in
<strong><?php 
$page_view = views_get_page_view(); // for a page display
$arg0 = $page_view->view->args[0];

if (!empty($arg0))
{
print_r(str_replace('-', ' ', ucwords($arg0)));
}
else 
{
    
    print_r("Everyone");
}
?></strong>. Showing <?php echo '<strong>'.number_format($view->total_rows).' </strong>';?> with <?php echo (intval($view->total_rows) == 1) ? ' profile' : ' profiles'?>.
</span>
</div>

 <div class="ag-header">
  
   <div class="ag-sort">
	<p>Sort</p>
    <div id="items-sort-selector" class="ag-sort-container">
    	<select>
    		<option value="field_per_fname_value_sort=unsorted&created_sort=unsorted&has_prof_sort=DESC"<?php echo ($has_prof_sort == 'DESC') ? ' selected="selected"' : ''; ?>>With profile first</option>
			<option value="field_per_fname_value_sort=unsorted&created_sort=DESC&has_prof_sort=unsorted"<?php echo ($created_sort == 'DESC') ? ' selected="selected"' : ''; ?>>Newest</option>
			<option value="field_per_fname_value_sort=ASC&created_sort=unsorted&has_prof_sort=unsorted"<?php echo ($field_per_fname_value_sort == 'ASC') ? ' selected="selected"' : ''; ?>>A-Z</option>
		</select>
	</div>
</div> 
  
  
<div class="ag-sort hidden">
<p>Results</p>
<div id="pagesize-selector" class="ag-sort-container">
<select>
<option value="30"<?php echo ($items_per_page_override == 30) ? ' selected="selected"' : ''; ?>>30</option>
<option value="60"<?php echo ($items_per_page_override == 60) ? ' selected="selected"' : ''; ?>>60</option>
<option value="120"<?php echo ($items_per_page_override == 120) ? ' selected="selected"' : ''; ?>>120</option>
</select>
</div>
</div>
 	<div class="right">
	<a href="/export-people" target="_blank" class="export-results right">Export results (XLS)</a>
	</div> 
  
  
  
  
  
  
  
    <?php if ($pager): ?>
      <?php //print $pager; ?>
  <?php endif; ?>
  </div>

<div class="clear-block"></div>
<div id="article-list-view">
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
</div>
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