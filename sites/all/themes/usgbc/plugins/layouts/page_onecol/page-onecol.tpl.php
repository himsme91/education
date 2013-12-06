<?php
// $Id: page-onecol.tpl.php 4085 2011-09-23 22:05:03Z pnewswanger $
/**
 * @file
 * Template for a 1 column panel layout.
 *
 * This template provides a very simple "one column" panel display layout.
 *
 */
?>
<div class="subcontent-wrapper" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div id="mainCol">
    <?php print $content['main']; ?>
  </div>
</div>
