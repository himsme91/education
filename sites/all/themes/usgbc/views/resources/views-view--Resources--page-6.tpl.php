<?php
// $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');

drupal_add_js(drupal_get_path('theme', 'usgbc') .'/lib/js/jquery.pagingselection.js');

$items_per_page_override = ($_GET['pagesize'] > 0) ? $_GET['pagesize'] : 30;

$title = ($_GET['title'] != '') ? $_GET['title'] : 'Search resources';

$title_sort = ($_GET['title_sort'] == 'unsorted' || $_GET['title_sort'] == '') ? $_GET['title_sort'] : 'ASC';

$changed_sort = ($_GET['changed_sort'] == 'unsorted' || $_GET['changed_sort'] == '') ? $_GET['changed_sort'] : 'DESC';

$created_sort = ($_GET['created_sort'] == 'unsorted' || $_GET['created_sort'] == '') ? $_GET['created_sort'] : 'DESC';

$pageurl = USGBCHOST.$_SERVER["REQUEST_URI"];

$viewlist_url = str_replace("grid","list",$pageurl);

$viewgrid_url = str_replace("list","grid",$pageurl);

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
				<input type="text" class="jumbo-search-field default" name="title"
					value="<?php echo $title ; ?>"> <input type="submit"
					class="jumbo-search-button" name="" value="Search"
					src="/themes/usgbc/lib/img/search-icon-button.gif">
			</form>
		</div>
	</div>
  
  
  
  
  <!-- <div class="view-filters"> 
      <?php print $exposed; ?>
    </div>  --> 
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

	<div class="search-report aside">
		<span> <?php echo '<strong>'.number_format($view->total_rows).' </strong>';?> <?php echo (intval($view->total_rows) == 1) ? ' result' : ' results'?>
			in <strong> <?php 
			$page_view = views_get_page_view(); // for a page display
			$arg0 = $page_view->view->args[0];
			$arg1 = $page_view->view->args[1];

			if (!empty($arg1))
			{
				if($arg1 == "all")
				print_r("All");
				elseif($arg1 == "usgbc")
				print("USGBC");
				else
				print_r(ucwords($arg1));
					
			}
			else
			{
				if (!empty($arg0))
				{
					if($arg0 == "all")
					print_r("All");
					else
					print_r(ucwords($arg0));
				}
				else
				{
					print_r("All");
				}
			}
			?> </strong> under favorites.</span>
	</div>
	<div class="ag-header">

		<div class="ag-sort">
			<p>Sort</p>
			<div id="items-sort-selector" class="ag-sort-container">
				<select>
					<option
						value="title_sort=ASC&changed_sort=unsorted&created_sort=unsorted"
						<?php echo ($title_sort == 'ASC') ? ' selected="selected"' : ''; ?>>A-Z</option>
					<option
						value="title_sort=unsorted&changed_sort=unsorted&created_sort=DESC"
						<?php echo ($created_sort == 'DESC') ? ' selected="selected"' : ''; ?>>Newest</option>
					<option
						value="title_sort=unsorted&changed_sort=DESC&created_sort=unsorted"
						<?php echo ($changed_sort == 'DESC') ? ' selected="selected"' : ''; ?>>Updated</option>
				</select>
			</div>
		</div>


		<div class="ag-sort">
			<p>Results</p>
			<div id="pagesize-selector" class="ag-sort-container">
				<select>
					<option value="30"
					<?php echo ($items_per_page_override == 30) ? ' selected="selected"' : ''; ?>>30</option>
					<option value="60"
					<?php echo ($items_per_page_override == 60) ? ' selected="selected"' : ''; ?>>60</option>
					<option value="120"
					<?php echo ($items_per_page_override == 120) ? ' selected="selected"' : ''; ?>>120</option>
				</select>
			</div>
		</div>
		<div class="ag-sort hidden" id="ag-list-view">
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

