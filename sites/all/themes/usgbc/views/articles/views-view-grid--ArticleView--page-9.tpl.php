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
<?php 
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');	
//print_r($rows);	

//dsm($Arguments);
list($arg0, $arg1, $arg2) = split('[/]', $_GET['q']);
//dsm($arg2);
?> 


<div class="ch-feat">
    <div class="ch-feat-header">
        <h1><?php print $arg2;?></h1>
    </div>
    
    <?php foreach ($rows as $row_number => $columns): ?>
    	<?php foreach ($columns as $column_number => $item): ?>
	  		<?php if (!empty($item)) : ?>
            	<div class="feat-article">
            		<?php print $item;?>
           		</div>
		   	<?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
