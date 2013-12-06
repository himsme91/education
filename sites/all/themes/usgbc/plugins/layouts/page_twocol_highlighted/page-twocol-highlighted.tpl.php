<?php
// $Id: page-twocol-highlighted.tpl.php 4049 2011-09-23 20:20:59Z pnewswanger $
/**
 * @file
 * Template for a 2 column panel layout with an optional highlighted block at the top.
 */
?>
<div class="subcontent-wrapper" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>

  <?php if(!empty($content['highlighted'])): ?>
  <div id="highlighted">
    <?php print $content['highlighted']; ?>
  </div>
  <?php endif; ?>

  <div id="mainCol">
    <?php print $content['main']; ?>
  </div>
  
  <div id="sideCol">
    <?php print $content['side']; ?>
  </div>

</div>
