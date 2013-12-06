

<style type="text/css">
.views-exposed-widget { display:none;}
</style>

<?php 
include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters.php';
//dsm($view);
//dsm($exposed);


drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');

drupal_add_js(drupal_get_path('theme', 'usgbc') .'/lib/js/jquery.pagingselection.js');

$items_per_page_override = ($_GET['pagesize'] > 0) ? $_GET['pagesize'] : 30;

$title = ($_GET['keys'] != '') ? $_GET['keys'] : 'Search credits';

$title_sort = ($_GET['title_sort'] == 'unsorted' || $_GET['title_sort'] == '') ? $_GET['title_sort'] : 'ASC';

$changed_sort = ($_GET['changed_sort'] == 'unsorted' || $_GET['changed_sort'] == '') ? $_GET['changed_sort'] : 'DESC';

$field_credit_short_id_value_sort = ($_GET['field_credit_short_id_value_sort'] == 'unsorted' || $_GET['field_credit_short_id_value_sort'] == '') ? $_GET['field_credit_short_id_value_sort'] : 'ASC';

$page_view = views_get_page_view();

$currenturl = explode("?", $_SERVER['REQUEST_URI']);
$counter = 0;
$node_data = node_load($fields['nid']->content);
dsm($node_data);
$_SESSION['creditnav'] = null;
foreach($view->result as $credit_row){
	$counter_next     = $counter + 1;
	$counter_previous = $counter - 1;
	
	$next_item = $view->result[$counter_next];
	$previous_item = $view->result[$counter_previous];
	$_SESSION['creditnav'][$credit_row->nid]['previous'] = $previous_item->nid;
	$_SESSION['creditnav'][$credit_row->nid]['next']     = $next_item->nid;

//	if($counter == 0) $_SESSION['creditnav']['next'][$credit_row->nid] = null;
//	if(!is_set($credit_row[$counter+1])) $_SESSION['creditnav']['next'][$credit_row->nid] = null;
	$counter++;
}

?>

<div class="subcontent-wrapper">

		<div id="mainCol" class="<?php print $classes; ?>">
  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links;
      ?>
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
                          <input id="edit-title" type="text" class="jumbo-search-field default" name="keys" value="<?php echo $title ; ?>" defaultvalue="Search credits">
                          <input type="submit" class="jumbo-search-button" name="" value="Search" src="/themes/usgbc/lib/img/search-icon-button.gif">   
                        </form>
                    </div>
                </div>
  <!--  <div class="view-filters">
      
    </div> -->
     
<?php include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-ui.php'; ?>  
   
    
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>
<!--<div class="search-report aside" >
<span>
    <?php echo '<strong>'.number_format($view->total_rows).' </strong>';?>
<?php echo (intval($view->total_rows) == 1) ? ' result' : ' results'?>
<?php if ($title != 'Search credits') : ?>
<?php print ' for ';?>
<strong>
<?php print $title;?>
</strong>
<?php endif; ?>
 in
<strong><?php 
$arg0 = $page_view->view->args[2];

if (!empty($arg0))
{
print_r(str_replace('-', ' ', ucwords($arg0)));
}
else 
{
    
    print_r("All");
}
?></strong>.
</span>
</div>-->
<!--  <div class="ag-header">
<div class="ag-sort">
	<p>Sort</p>
    <div id="items-sort-selector" class="ag-sort-container">
    	<select>
    		<option value="title_sort=unsorted&changed_sort=unsorted&field_credit_short_id_value_sort=ASC"<?php echo ($field_credit_short_id_value_sort == 'ASC') ? ' selected="selected"' : ''; ?>>ID</option>
			<option value="title_sort=ASC&changed_sort=unsorted&field_credit_short_id_value_sort=unsorted"<?php echo ($title_sort == 'ASC') ? ' selected="selected"' : ''; ?>>A-Z</option>
			<option value="title_sort=unsorted&changed_sort=DESC&field_credit_short_id_value_sort=unsorted"<?php echo ($changed_sort == 'DESC') ? ' selected="selected"' : ''; ?>>Updated</option>
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
-->
<div class="clear-block"></div>

<?php if (user_access("create credit_definition content")): ?>
  <div class="search-report aside">
	<a target="_blank" href="/node/add/credit-definition/">New</a>
</div>
<?php endif;?>
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



<div class="clear-block"></div>
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


</div>

