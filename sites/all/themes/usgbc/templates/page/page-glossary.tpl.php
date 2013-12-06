<?php
  // $Id: page.tpl.php 13883 2012-02-07 15:37:39Z pkhanna $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */


  include('page_inc/page_top.php'); 
?>

<div id="content" class="oneCol">
 <?php
	  	$type_block = module_invoke('glossary','block','view','0');
		print $type_block['content']; ?>
		
  <?php print $content; ?>

</div><!--content-->

<?php include('page_inc/page_bottom.php'); ?>