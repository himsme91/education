<?php
// $Id: page-twocol-leftmain.tpl.php 2012-12-03 jmehta $
/**
 * @file
 * Template for a 2 column panel layout with wider left section.
 */
?>
<div class="subcontent-wrapper" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>

  <div id="mainCol">
    <?php print $content['main']; ?>
  </div>
  
  <div id="sideCol">
    <?php print $content['side']; ?>
  </div>

</div>
