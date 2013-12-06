<?php
  // $Id: page-course.tpl.php 6782 2013-01-03 11:56:44 jmehta $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */

  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/node/press/css/styles.css" />';
  $scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/node/leaders/jquery.tweet.js"></script>';

    include('page_inc/page_top.php'); ?>

<div class="oneCol">
    <?php print $content; ?>
</div><!--content-->


<?php include('page_inc/page_bottom.php'); ?>