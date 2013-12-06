<?php
// $Id: page-content.tpl.php 7898 2011-11-03 16:08:35Z pnewswanger $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */


include('page_inc/page_top.php'); ?>      
      
<?php if(!empty($section_sub_menu)): ?>

<div id="content" class="twoColRight">
  
      <div id='navCol' class='clearfix'>
          <?php if (!empty($section_sub_menu)) print $section_sub_menu; ?>
      </div>
      
      	<div class="subcontent-wrapper">
      			<div id="mainCol">
      				<?php print $content; ?>
      			</div>
      	</div>
  
</div><!--content-->

<?php else: ?>

<div id="content" class="oneCol">
      
      <?php print $content; ?>
  
</div><!--content-->

<?php endif; ?>
      

<p><?php echo$node->type; ?>: <?php echo $node->nid; ?></p>

<?php include('page_inc/page_bottom.php'); ?>