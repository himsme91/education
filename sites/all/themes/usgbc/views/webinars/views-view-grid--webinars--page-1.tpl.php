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

  <div class="jcarousel-skin-tango bg-grid">
    <?php 
    $col = array();
    foreach ($rows as $row_number => $columns){
      
      foreach ($columns as $column_number => $item){
        if(!empty($item)) $col[$column_number] .= '<div class="jcarousel-item jcarousel-item-horizontal">'.$item.'</div>';
      }
    
    }
    ?>
    
    <?php foreach ($col as $column): ?>
          
      <div class="bg-column">
        <?php print $column;?>
      </div>
          
    <?php endforeach; ?>
          
      
  </div>