<style>
#main-col{
font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif !important;
}
#course-list .result td, table.ag-table .result td {
    border-bottom: 1px solid #DDDDDD;
    font-size: 12px;
    font-weight: normal;
}
</style>

<h3>LEED v4 Forms</h3>
<p><strong>VARIATIONS</strong>
Many requirements for a credit are aligned across the BD+C and ID+C rating systems. When that is the case, there is one form for all aligned rating systems.  If there are minor changes for certain adaptations (e.g. Healthcare), those are also included in the same form.  These are called variations.  Variations are listed below.  You will see the list of rating systems and adaptations included in the form at the top of the form.  These selections will not be visible in LEED Online, they will be selected based upon registration. 
</p> 
<p>In some instances, prerequisite and related credit forms have been combined into one form, e.g. EA Prerequisite Minimum Energy Performance and EA Credit Optimize Energy Performance. Therefore, every credit does not necessarily have a unique form.
</p> 
<p><strong>UNITS</strong>
Projects must select either IP (inch-pound) or SI (International System of Units) units for their entire project.  These selections will not be visible in LEED Online, they will be selected based upon registration.  In the sample forms, both options are available.  Not all forms include IP/SI unit variations, however, all forms have those selections visible in sample forms.
</p> 
<p><strong>RECERTIFICATION</strong>
LEED O+M forms have requirements for both project teams pursuing their first O+M certification and those that are coming back for recertification.  These selections will not be visible in LEED Online, they will be selected based upon registration. 
</p> 
<p><strong>CREDIT RESOURCES</strong>
If a credit has an associated calculator, it is listed below and can also be found under the Resources tab in the credit library.
</p>
<hr>
<p><a href="resources/lov3-forms-fix-log">LOv3 Forms Fix Log</a> - A catalog of all forms corrected in LEED Online v3, sorted by rating system.
</p>
<p><a href="resources/lov3-credit-matrix">LOv3 Credit Matrix</a> - A catalog of form content and data linkages, sorted by rating system.
</p>


<?php 

include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters.php';

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
	
	<?php 
	if ($exposed): 
		print $exposed; ?>
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
    
    <div class="search-report aside hidden">
		<span> <?php echo '<strong>'.number_format($view->total_rows).' </strong>';?> <?php echo (intval($view->total_rows) == 1) ? ' result' : ' results'?>
			in <strong> <?php 
			$page_view = views_get_page_view(); // for a page display
			$arg0 = $page_view->view->args[0];
		//	$arg1 = $page_view->view->args[1];

			if (!empty($arg0))
				{
					if($arg0 == "")
					print_r("All.");
					else 
					print_r(str_replace('-', ' ', ucwords($arg0)) . ".");
				}
				else
				{
					print_r("All.");
				}
			
			?> </strong> </span>
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

	<?php if ($pager): 
			print $pager; 	
		endif; ?>
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
	
	
</div>