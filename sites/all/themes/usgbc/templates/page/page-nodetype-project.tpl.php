<?php
  // $Id: page-nodetype-project.tpl.php 6900 2011-10-17 22:43:44Z jmehta $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */
  $styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/css/section/directory.css" />';
?>

<?php include('page_inc/page_top.php'); ?>

<div class="twoColLeft" id="content" itemscope itemtype="http://schema.org/Place">
  <?php print $content; ?>
</div>

<?php include('page_inc/page_bottom.php'); ?>
