<?php
drupal_add_js(drupal_get_path('theme', 'usgbc') .'/lib/js/jquery.pagingselection.js');

$items_per_page_override = ($_GET['pagesize'] > 0) ? $_GET['pagesize'] : 30;

$title = ($_GET['name'] != '') ? $_GET['name'] : 'Search help';

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
  <div id="mainCol">
  <?php if ($exposed): ?>
  
  <div id="events-search" class="jumbo-search">
                    <div class="jumbo-search-container">
                      <form action="/help/search-results" method="get">
                        <input type="text" class="jumbo-search-field default" name="name" value="<?php echo $title ; ?>" defaultvalue="Search help">
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
	<?php if ($title != 'Search help') : ?>
	<?php print ' for ';?>
	<strong>
	<?php print $title;?>
	</strong>
	<?php endif; ?>
	</span>
</div>
<div class="ag-header">	
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


