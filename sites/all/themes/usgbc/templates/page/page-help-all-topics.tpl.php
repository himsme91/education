<?php
  // $Id: page-course.tpl.php 6782 2011-10-17 14:09:44Z jmehta $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */

  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/help.css" />';


  include('page_inc/page_top.php'); ?>

<div id="content">
 
    <?php print $content; ?>

</div>

<?php include('page_inc/page_bottom.php'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		<?php if($currenturl[0] != '/help'):?>	
			//This is the id for the "Help" menu item. We are keeping it active - JM
			//Dev site id is "dhtml_menu-15807"
			$("#dhtml_menu-15753").removeClass("active-trail").addClass("active-trail active");
		<?php endif;?>
	});
</script>
