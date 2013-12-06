<div class="<?php print $classes; ?>">
	  <?php if ($admin_links): ?>
	    <div class="views-admin-links views-hide">
	      <?php print $admin_links; ?>
	    </div>
	  <?php endif; ?>

	  <?php 
	  	include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/revisions.php';
	  ?>
	  