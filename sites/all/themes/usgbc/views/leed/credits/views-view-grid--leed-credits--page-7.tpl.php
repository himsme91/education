<?php
// $Id: views-view-grid.tpl.php,v 1.3.4.1 2010/03/12 01:05:46 merlinofchaos Exp $
/**
 * @file views-view-grid.tpl.php
 * Default simple view template to display a rows in a grid.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 *
 * @ingroup views_templates
 */
?>



<?php if (!empty($title)) : ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<h3>Resources</h3>
<div class="sell-pubs">
    <?php foreach ($rows as $row_number => $columns): ?>
        <?php foreach ($columns as $column_number => $item): ?>
         <?php if (!empty($item)) : ?>
          <div class="sell-item block-link"  >
           
        	<?php print $item; ?>
        	
          </div>
          <?php endif;?>
        <?php endforeach; ?>
     
    <?php endforeach; ?>
</div>