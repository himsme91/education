<?php
  // $Id: page-comment.tpl.php 11186 2011-12-22 00:29:30Z pnewswanger $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */

  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/blog.css" />';
  include('page_inc/page_top.php');
?>

<div id="content" class="oneCol">
  <div class="entry-column">
    <div id="comments">
      <div id="comment-feed">
        <?php print $content; ?>
      </div>
    </div>
  </div>


</div><!--content-->



<?php include('page_inc/page_bottom.php'); ?>
