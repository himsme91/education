<?php 

include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters.php';
drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');
drupal_add_js(drupal_get_path('theme', 'usgbc') .'/lib/js/jquery.pagingselection.js');
drupal_add_css(drupal_get_path('theme', 'usgbc') .'/lib/css/section/directory.css');


$items_per_page_override = ($_GET['pagesize'] > 0) ? $_GET['pagesize'] : 30;

$title = ($_GET['keys'] != '') ? $_GET['keys'] : 'Search projects';

$title_sort = ($_GET['title_sort'] == 'unsorted' || $_GET['title_sort'] == '') ? $_GET['title_sort'] : 'ASC';

$changed_sort = ($_GET['changed_sort'] == 'unsorted' || $_GET['changed_sort'] == '') ? $_GET['changed_sort'] : 'ASC';

$created_sort = ($_GET['created_sort'] == 'unsorted' || $_GET['created_sort'] == '') ? $_GET['created_sort'] : 'ASC';

$pageurl = USGBCHOST.$_SERVER["REQUEST_URI"];

$viewlist_url = str_replace("/projects","/projects/list",$pageurl);

$viewgrid_url = str_replace("/projects/list","/projects",$pageurl);

$currenturl = explode("?", $_SERVER['REQUEST_URI']);


?>

<div id="leed-projects" class="<?php print $classes; ?>">
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
            <input type="text" class="jumbo-search-field default" name="keys" 
            value="<?php echo $title ; ?>"> <input type="submit" 
            class="jumbo-search-button" name="" value="Search" 
            src="/themes/usgbc/lib/img/search-icon-button.gif">
          </form>         	                    	                    	    
      </div>
  </div>
       
<?php include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-ui.php'; ?>  
  
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>
<!--
<a href="/projects/exportxls" tagart="_blank" class="export-results right">Export results (CSV)</a>
-->

  <div class="ag-header">
  
 <div class="ag-sort">
	<p>Sort</p>
    <div id="items-sort-selector" class="ag-sort-container">
    	<select>
    		<option value="title_sort=unsorted&changed_sort=ASC&created_sort=unsorted"<?php echo ($changed_sort == 'ASC') ? ' selected="selected"' : ''; ?>>Updated</option>
			<option value="title_sort=ASC&changed_sort=unsorted&created_sort=unsorted"<?php echo ($title_sort == 'ASC') ? ' selected="selected"' : ''; ?>>A-Z</option>
			<option value="title_sort=unsorted&changed_sort=unsorted&created_sort=ASC"<?php echo ($created_sort == 'ASC') ? ' selected="selected"' : ''; ?>>Newest</option>
			
		</select>
	</div>
</div> 

<div class="ag-sort" id="ag-list-view">
			<p>View</p>
			<div class="ag-sort-container">
				<h3>
					<a href="<?php print $viewgrid_url?>"><span class="thumb-view">Thumbnail
							View</span> </a>
				</h3>
				<ul class="sort-items">
					<li><a class="selected" href="<?php print $viewgrid_url?>"><span
							class="thumb-view">Thumbnail view</span> </a></li>

					<li><a href="<?php print $viewlist_url?>"><span class="list-view">List
								view</span> </a></li>
				</ul>
			</div>
			<!-- ag-sort-container -->
		</div>
		<div class="right" style="padding-top:4px">
			<a href="/export-projects" target="_blank" class="export-results right">Export results (XLS)</a>
		</div>
		<?php global $user;?>
		<?php if ($user->uid): ?>
		<div class="right">
  			<a class="small-alt-button" href="/project-download-all">DOWNLOAD ALL</a>
  		</div>
  		<?php else:?>
  		<div class="right">
  			<a class="small-alt-button jqm-form-trigger" href="/user/login?destination=projects/list">DOWNLOAD ALL</a>
  		</div>
  		<?php endif;?>
    <?php //if ($pager): ?>
      <?php //print $pager; ?>
    <?php //endif; ?>
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

